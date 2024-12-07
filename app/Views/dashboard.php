<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to e-Office</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #00a8ff, #9c88ff);
            overflow: hidden;
            color: #fff;
        }

        .welcome-container {
            text-align: center;
            padding: 40px;
            max-width: 500px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            animation: fadeIn 2s ease-out;
        }

        .welcome-container h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            color: #f5f6fa;
            animation: slideIn 1s ease-out;
        }

        .welcome-container p {
            font-size: 1.2em;
            line-height: 1.6;
            color: #dcdde1;
            animation: fadeInText 3s ease-out;
        }

        /* Animation effects */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInText {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Floating circles for background decoration */
        .circle {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            animation: float 10s infinite ease-in-out;
            opacity: 0.7;
        }

        .circle1 { width: 80px; height: 80px; top: 10%; left: 15%; }
        .circle2 { width: 100px; height: 100px; top: 70%; left: 80%; animation-duration: 12s; }
        .circle3 { width: 60px; height: 60px; top: 50%; left: 25%; animation-duration: 8s; }
        .circle4 { width: 120px; height: 120px; top: 20%; left: 70%; animation-duration: 15s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(20px); }
        }
    </style>
</head>
<body>

<div class="welcome-container">
    <h1>Welcome to To Do List Web, <?=session()->get('username')?></h1>
    
</div>

<!-- Decorative circles for animated background -->
<div class="circle circle1"></div>
<div class="circle circle2"></div>
<div class="circle circle3"></div>
<div class="circle circle4"></div>

</body>
</html>
