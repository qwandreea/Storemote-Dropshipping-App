<html>
    <head>
        <title>Pagina nu exista</title>
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    </head>

    <style>
        body{
            background-color: black;
            text-align: center;
            font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
        }
        .message{
            color: white;
            margin-top:10%;
        }
        .shine {
           font-size: 50px;
            background: #222 -webkit-gradient(linear, left top, right top, from(#222), to(#222), color-stop(0.5, #fff)) 0 0 no-repeat;
            -webkit-background-size: 150px;
            background-size: 150px;
            color: rgba(255, 255, 255, 0.3);
            -webkit-background-clip: text;
            -webkit-animation-name: shine;
            animation-name: shine;
            -webkit-animation-duration: 12s;
            animation-duration: 5s;
            -webkit-animation-iteration-count: infinite;
            animation-iteration-count: infinite;
            text-shadow: 0 0px 0px rgba(255, 255, 255, 0.2);
        }

        @-webkit-keyframes shine {
            0%, 10% {
                background-position: -1000px;
            }
            20% {
                background-position: top left;
            }
            90% {
                background-position: top right;
            }
            100% {
                background-position: 1000px;
            }
        }

        @keyframes shine {
            0%, 10% {
                background-position: -1000px;
            }
            20% {
                background-position: top left;
            }
            90% {
                background-position: top right;
            }
            100% {
                background-position: 1000px;
            }
        }
        .button{
            width: 500px;
            height: 70px;
            background-color: #886f4a;
            opacity: 0.8;
            border-radius: 10px;
            font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
            color: white;
            font-size: 26px;
            padding-top: -20px;
        }
        .button:hover{
            background-color: white;
            color: #886f4a;
        }
    </style>

    <body>
        <div class="message">
            <p class="shine">STOREMOTE</p>
            <h2>Ne pare rau, pagina nu a fost gasita.</h2>
            <a href="/produse"><button class="button" href="/">
                    Inapoi la magazin</button></a>
        </div>
    </body>
</html>
