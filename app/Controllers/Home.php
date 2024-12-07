<?php

namespace App\Controllers;
use App\Models\M_burger;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\Database\Config;

class Home extends BaseController
{
    public function __construct()
    {
        $this->M_burger = new M_burger();
    }
    public function dashboard()   
    {
        if(session()->get('level')>0){ 
            $model= new M_burger;
            $user_id = session()->get('id');
        $data['jes'] = $model->tampilgambar('toko'); // Mengambil data dari tabel 'toko'


        $model->logActivity($user_id, 'dashboard', 'User in dashboard page');
        echo view('header');
        echo view('menu', $data); 
        echo view('dashboard'); 
    }else{
        return redirect()->to('http://localhost:8080/home/login');
    }
}
public function login()
{
    echo view('header');
    echo view('login');

}

public function aksi_login() {
    $u = $this->request->getPost('username');
    $p = $this->request->getPost('pw');

    // Inisialisasi model
    $model = new M_burger();

    // Mengatur kondisi pencarian
    $where = [
        'username' => $u,
        'pw' => md5($p)
    ];

    // Periksa apakah data user ditemukan
    $cek = $model->getWhereLogin('user', $where);

    if ($cek) {
        // Set session jika login berhasil
        session()->set('id', $cek->id_user);
        session()->set('username', $cek->username);
        session()->set('level', $cek->level);

        // Log aktivitas login
        // $model->logActivity($cek->id_user, 'login', 'User logged in.');

        return redirect()->to('home/dashboard');
    } else {
        // Redirect ke halaman login jika gagal
        return redirect()->to(base_url('home/login'));
    }
}
public function activity_log() {   
    if (session()->get('level') > 0) {
        $model = new M_burger();
        $logs = $model->getActivityLogs();
        $data['logs'] = $logs;

        $where = array(
            'id_toko' => 1
        );
        $setting = $model->getWhere('toko', $where);
        $data['jes'] = $model->tampilgambar('toko');

        $data['setting'] = $setting ? $setting : []; // Jika setting kosong, set sebagai array kosong

        echo view('header');
        echo view('menu', $data);
        return view('activity_log', $data);
    } else {
        return redirect()->to('http://localhost:8080/home/login');
    }
}

public function logout() {
    $user_id = session()->get('id');
    
    if ($user_id) {
        // Log the logout activity
        $model = new M_burger();
        $model->logActivity($user_id, 'logout', 'User logged out.');
    }

    session()->destroy();
    return redirect()->to('http://localhost:8080/home/login');
}


public function user()
{
    if (session()->get('level')> 0) {
        $model = new M_burger();
        $data['jel'] = $model->tampil('user');
        $data['jes'] = $model->tampilgambar('toko');
        
        $id = 1; // id_toko yang diinginkan

        // Menyusun kondisi untuk query
        $where = array('id_toko' => $id);

        // Mengambil data dari tabel 'toko' berdasarkan kondisi
        $data['user'] = $model->getWhere('toko', $where);

        // Memuat view
        // $data['setting'] = $model->getWhere('toko', $where);

        $user_id = session()->get('id');
        $model->logActivity($user_id, 'user', 'User in user page');

        echo view('header');
        echo view('menu', $data);
        echo view('user', $data);
    } else {
        return redirect()->to(base_url('home/login'));
    }
}

public function t_user()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    $data['jes'] = $model->tampilgambar('toko');
    
    $data['jel']= $model->tampil('user');
    $model->logActivity($user_id, 'tambah user', 'User in tambah user page');
    echo view('header');
    echo view('menu', $data);
    echo view('t_user',$data);
}

public function aksi_t_user()
{
    $user_id = session()->get('id');
    $a = $this->request->getPost('username');
    $b = md5($this->request->getPost('pass'));
    $u = $this->request->getPost('level');

    // Prepare the data for inserting into the 'user' table
    $sis = array(
        'level' => $u,
        'username' => $a,
        'pw' => $b
    );

    // Instantiate the model and add the new user data
    $model = new M_burger;
    $model->tambah('user', $sis);

    $model->logActivity($user_id, 'user', 'User added a new account');  

    // Redirect the user after the operation is completed
    return redirect()->to('http://localhost:8080/home/user');
}

public function h_user($id)
{
    $model = new M_burger();
    $id_user = session()->get('id');
    $kil = array('id_user' => $id);
    $model->hapus('user', $kil);
    $model->logActivity($id_user, 'user', 'User deleted a user data.');
    return redirect()->to(base_url('home/user'));
}

public function aksi_reset($id)
{
    $model = new M_burger();
    $user_id = session()->get('id');

    $where= array('id_user'=>$id);

    $isi = array(

        'pw' => md5('dream123')      

    );
    $model->editpw('user', $isi,$where);
    $model->logActivity($user_id, 'user', 'User reset a password');  

    return redirect()->to('home/user');
}

public function aksi_e_user()
{
    $model = new M_burger;
    $user_id = session()->get('id');
    $username = $this->request->getPost('username');
    $password = md5($this->request->getPost('pw'));  // Menggunakan md5 untuk hash password
    $level = $this->request->getPost('level');
    $id = $this->request->getPost('id_user');

    $where = ['id_user' => $id];
    $data = [
        'username' => $username,
        'pw' => $password,
        'level' => $level
    ];

    $model->edit('user', $data, $where);
    $model->logActivity($user_id, 'user', 'User updated a user data');

    return redirect()->to(base_url('home/user'))->with('success', 'User updated successfully');
}

public function register()
{
    $model= new M_burger;
    $data['jel']= $model->tampil('user');
    echo view('header');
    echo view('register',$data);
}
public function aksi_t_register()
{
    $a= $this->request->getPost('nama');
    $b= md5($this->request->getPost('pass'));
    $sis= array(
        'level'=>'2',
        'username'=>$a,
        'pw'=>$b);
    $model= new M_burger;
    $model->tambah('user',$sis);
    return redirect()-> to ('http://localhost:8080/home/login');
}

public function setting()
{
    if (session()->get('level') > 0) {
        $model = new M_burger();
        $user_id = session()->get('id');
        $data['jes'] = $model->tampilgambar('toko'); // Mengambil data dari tabel 'toko'
        $model->logActivity($user_id, 'setting', 'User in setting page');
        
        echo view('header');
        echo view('menu', $data); // Mengirimkan data ke menu.php
        echo view('setting', $data); // Mengirimkan data ke setting.php
    } else {
        return redirect()->to('http://localhost:8080/home/login');
    }
}

public function aksietoko()
{
    $model = new M_burger();
    $user_id = session()->get('id');
    $nama = $this->request->getPost('nama');
    $id = $this->request->getPost('id');
    $uploadedFile = $this->request->getFile('foto');

    $where = array('id_toko' => $id);

    $isi = array(
        'nama_toko' => $nama
    );

    // Check if a new file is uploaded
    if ($uploadedFile && $uploadedFile->isValid() && !$uploadedFile->hasMoved()) {
        $foto = $model->uploadgambar($uploadedFile); // Upload the new logo and delete the old one
        $isi['logo'] = $foto; // Add the new logo file name to the data array
    }

    $model->logActivity($user_id, 'user', 'User changed the profile company');

    // Update the store's name and logo in the database
    $model->editgambar('toko', $isi, $where);

    return redirect()->to('home/setting');
}


public function list()
{
    $model = new M_burger;
    $user_id = session()->get('id');
    $data['jes'] = $model->tampilgambar('toko');

    $deadlineFilter = $this->request->getVar('deadline');
    $data['deadlineFilter'] = $deadlineFilter;

    $query = "SELECT * FROM list WHERE id_user = '$user_id' AND deleted_at IS NULL";
    if ($deadlineFilter) {
        $query .= " AND DATE(deadline) = '$deadlineFilter'";
    }
    $data['jel'] = $model->query($query);

    echo view('header');
    echo view('menu', $data);
    echo view('list', $data);
}



public function aksi_t_list()
{
    // Load model
    $model = new \App\Models\M_burger();
    $user_id = session()->get('id');

    // Ambil data dari form
    $data = [
        'id_user'     => session()->get('user_id'), // Pastikan session user_id tersedia
        'title'       => $this->request->getPost('title'),
        'description' => $this->request->getPost('description'),
        'status'      => 'undo', // Set status default
        'deadline'    => $this->request->getPost('deadline'),
        'created_at'  => date('Y-m-d H:i:s'), // Set waktu saat ini
        'id_user' => $user_id
    ];

    // Masukkan data ke database
    if ($model->tambah('list', $data)) {
        return redirect()->to(base_url('home/list'))->with('success', 'To-Do berhasil ditambahkan!');
    } else {
        return redirect()->to(base_url('home/list'))->with('error', 'Gagal menambahkan To-Do.');
    }
}

public function update_t_list($id)
{
    $model = new \App\Models\M_burger();
    $user_id = session()->get('id');

    $data = [
        'title'       => $this->request->getPost('title'),
        'description' => $this->request->getPost('description'),
        'status'      => $this->request->getPost('status'),
        'deadline'    => $this->request->getPost('deadline'),
        'id_user' => $user_id
    ];

    if ($model->editgambar('list', $data, ['id_list' => $id])) {
        return redirect()->to(base_url('home/list'))->with('success', 'To-Do berhasil diperbarui!');
    } else {
        return redirect()->to(base_url('home/list'))->with('error', 'Gagal memperbarui To-Do.');
    }
}

public function update_status_failed($id_list)
{
    $this->db->table('todo_list')
             ->where('id_list', $id_list)
             ->update(['status' => 'failed']);
    
    return $this->response->setJSON(['success' => true]);
}


// public function h_list($id)
// {
//     $model = new M_burger();
//     $id_user = session()->get('id');
//     $kil = array('id_list' => $id);
//     $model->hapus('list', $kil);
//     $model->logActivity($id_user, 'list', 'User menghapus data to do list.');
//     return redirect()->to(base_url('home/list'));
// }

public function history()
{
    if (session()->get('level') > 0) {
        $model = new M_burger;
        $user_id = session()->get('id'); // Ambil ID user dari session

        // Ambil data toko
        $data['jes'] = $model->tampilgambar('toko');

        // Ambil data dengan status "complete" berdasarkan id_user
        $data['jel'] = $model->jointampilhistory($user_id);

        // Log aktivitas
        $model->logActivity($user_id, 'user', 'User accessed the history page');

        // Tampilkan view
        echo view('header');
        echo view('menu', $data);
        echo view('history', $data);
    } else {
        return redirect()->to('http://localhost:8080/home/login');
    }
}


public function h_list($id)
{
    $model= new M_burger;
    $user_id = session()->get('id');
    $kil= array('id_list'=>$id);
    $isi= array(
        'deleted_at'=>date('Y-m-d H:i:s'));
    $model->edit('list',$isi,$kil);
    $model->logActivity($user_id, 'list', 'User deleted a list');
    // $model->hapus('makanan',$kil);
    return redirect()-> to('http://localhost:8080/home/list');
}

public function restore()
{
    if (session()->get('level') > 0) {
        $model = new M_burger;
        $user_id = session()->get('id'); // Ambil ID user dari session

        // Ambil data toko
        $data['jes'] = $model->tampilgambar('toko');

        // Ambil data yang dihapus berdasarkan id_user
        $data['jel'] = $model->jointampilRestoreByUserId($user_id);

        // Log aktivitas
        $model->logActivity($user_id, 'user', 'User accessed the restore page');

        // Tampilkan view
        echo view('header');
        echo view('menu', $data);
        echo view('restore', $data);
    } else {
        return redirect()->to('http://localhost:8080/home/login');
    }
}


public function aksi_restore($id)
{
    $user_id = session()->get('id');
    $model = new M_burger();

    $where= array('id_list'=>$id);
    $isi = array(
        'deleted_at'=>NULL
    );
    $model->edit('list', $isi,$where);
    $model->logActivity($user_id, 'restore', 'User restore a data');  

    return redirect()->to('home/restore');
}

public function mark_complete($id)
{
    $model = new \App\Models\M_burger(); // Ganti dengan model Anda
    $data = [
        'status' => 'complete' // Menandai status sebagai "complete"
    ];

    if ($model->editgambar('list', $data, ['id_list' => $id])) {
        return redirect()->to(base_url('home/list'))->with('success', 'Task marked as complete!');
    } else {
        return redirect()->to(base_url('home/list'))->with('error', 'Failed to mark task as complete.');
    }
}


public function folder()
{
    if (session()->get('level')>0) {
        $model= new M_burger;
        $user_id = session()->get('id');
        $data['jes'] = $model->tampilgambar('toko');
        // $data['jel']=$model->tampil('folder');
        $data['jel'] = $model->joinfolder($user_id);
        $model->logActivity($user_id, 'user', 'User in folder page');
        echo view('header');
        echo view('menu',$data);
        echo view('folder',$data);
    }else{
        return redirect()->to('http://localhost:8080/home/login');
    }
}

public function aksi_t_folder()
{
    // Ambil data dari form
    $folder_name = $this->request->getPost('folder_name');
    $id_user = session()->get('id_user'); // Pastikan session ID user diatur

    // Data yang akan disimpan
    $data = [
        'id_user' => $id_user,
        'folder_name' => $folder_name,
        'created_at' => date('Y-m-d H:i:s') // Menyimpan timestamp saat ini
    ];

    // Load model dan tambahkan data
    $model = new M_burger();
    $result = $model->tambah('folder', $data);

    // Redirect dengan pesan
    if ($result) {
        return redirect()->to(base_url('home/folder'))->with('message', 'Folder added successfully.');
    } else {
        return redirect()->to(base_url('home/folder'))->with('error', 'Failed to add folder.');
    }
}












//laporan
public function laporan()
{
    if (session()->get('level')> 0) {
        $model = new M_burger();
        $user_id = session()->get('id');
             $data['jes'] = $model->tampilgambar('toko'); // Mengambil data dari tabel 'toko'
             $model->logActivity($user_id, 'laporan', 'User in laporan');
             echo view('header');
             echo view('menu', $data);
             echo view('laporan');
         } else {
            return redirect()->to('http://localhost:8080/home/error');
        }
    }


    public function generate_report()
    {
        if (session()->get('level') > 0) {
            $start_date = $this->request->getPost('start_date');
            $end_date = $this->request->getPost('end_date');
            $report_type = $this->request->getPost('report_type');

            switch ($report_type) {
                case 'pdf':
                $this->generate_pdf($start_date, $end_date);
                break;
                case 'excel':
                $this->generate_excel($start_date, $end_date);
                break;
                case 'window':
                $this->generate_window_result($start_date, $end_date);
                break;
                default:
                return redirect()->to('home/error');
            }
        } else {
            return redirect()->to('home/login');
        }
    }


    private function generate_pdf($start_date, $end_date)
    {
        $model = new M_burger();
        $data['laporan'] = $model->getLaporanByDate($start_date, $end_date);

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $html = view('laporan_pdf', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("laporan.pdf", array("Attachment" => false));
    }

    private function generate_excel($start_date, $end_date)
    {
        $model = new M_burger();
        $data['laporan'] = $model->getLaporanByDateForExcel($start_date, $end_date);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator("Your Name")->setLastModifiedBy("Your Name")
        ->setTitle("Laporan Loker")->setSubject("Laporan Loker")
        ->setDescription("Laporan Transaksi")->setKeywords("Spreadsheet")
        ->setCategory("Report");

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'title')
        ->setCellValue('B1', 'description')
        ->setCellValue('C1', 'status')
        ->setCellValue('D1', 'deadline')
        ->setCellValue('E1', 'created at')
        ->setCellValue('F1', 'deleted at');

        $rowCount = 2;
        foreach ($data['laporan'] as $row) {
            $sheet->setCellValue('A' . $rowCount, $row['title'])
            ->setCellValue('B' . $rowCount, $row['description'])
            ->setCellValue('C' . $rowCount, $row['status'])
            ->setCellValue('D' . $rowCount, $row['deadline'])
            ->setCellValue('E' . $rowCount, $row['created_at'])
            ->setCellValue('F' . $rowCount, $row['deleted_at']);
            $rowCount++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    private function generate_window_result($start_date, $end_date)
    {
        $model = new M_burger();
        $data['formulir'] = $model->getLaporanByDate($start_date, $end_date);
        echo view('cetak_hasil', $data);
    }



}
