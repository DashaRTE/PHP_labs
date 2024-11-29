<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Головна сторінка</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        div {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            text-align: center;
        }

        a {
            display: inline-block;
            padding: 12px 30px;
            margin: 10px 0;
            background-color: #007bff;
            color: white;
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        @media (max-width: 600px) {
            a {
                width: 80%;
                font-size: 16px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<div>
    <a href="../html/authorization_page.html">Увійти</a>
    <a href="../html/registration_page.html">Зареєструватись</a>
</div>
</body>
</html>
