<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>demo</title>
</head>
<body>
    <h1>領収書</h1>
    <form method="post" action="./receipt/receipt-pdf.php" target="_blank">
        <div>
            <div>No.</div>
            <div><input type="text" name="number" value="00" placeholder="No." required></div>
        </div>
        <div>
            <div>名前</div>
            <div><input type="text" name="name" value="山田太郎" placeholder="お名前" required></div>
        </div>
        <div>
            <div>金額</div>
            <div><input type="text" name="price" value="10000" placeholder="金額" required></div>
        </div>
        <div>
            <div>但し書き</div>
            <div><input type="text" name="proviso" value="お品代として" placeholder="但し書き" required></div>
        </div>
        <button type="submit">領収書PDFを作成</button>
    </form>
</body>
</html>