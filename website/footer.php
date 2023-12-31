<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Footer Page</title>
   <style>
    body {
        background-color: #FAF8F4;
        font-family: 'Times New Roman', Times, serif;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    footer {
        background-color: #433E36;
        color: #D7CA96;
        text-align: center;
        padding: 5px;
        box-sizing: border-box;
        margin-top: auto; 
    }
    
    footer a {
        color: #D7CA96;
        text-decoration: none;
        margin: 0 10px;
    }
    
    .footer-info {
        display: inline-flex;
        flex-wrap: wrap;
        justify-content: center;
        text-align: left;
        margin-top: 20px;
    }
    
    .footer-info div {
        flex: 1;
        margin: 10px;
    }
   </style>
</head>

<body>
    <footer>
        <div class="footer-info">
            <div>
                <h4>OPEN HOURS:</h4>
                <p>Tuesday - Sunday 11AM - 6PM</p>
                <p>Close on Monday and Public Holidays</p>
                <h4>For more information:</h4>
                <p><a href="mailto:info@theart.gallery">info@theart.gallery</a></p>
            </div>

            <div>
                <h4>TEL:</h4>
                <p>090-276-7007 (Chanikarn)</p>
                <p>095-894-4145 (Kanyarat)</p>
            </div>

            <div>
                <h4>ADDRESS:</h4>
                <p>345/25-26 The Headquarters,
                Intaraporn Rd., Plubpla, Wang Thonglang, Bangkok, Thailand 10310</p>
            </div>
        </div>
    </footer>
</body>
</html>
