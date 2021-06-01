# PHPでテンプレートデザインを作成する

イラストレーター等で作成したテンプレートデザインにプログラミング言語PHPを利用して流し込みできるサンプルを実装したので、自分への備考録も兼ねてまとめましたのでご紹介します。


□ 使用言語: PHP
前提 HTML/PHPの基礎的知識、フォーム送信が分かる方向け

□ テンプレート作成ツール
Adobe Illustrator推奨、解像度にこだわなければAdobe XDも可
他にもExcel、WordなどPDFを作成できるアプリケーションなら可


### ライブラリを用意
TCPDF: https://github.com/tecnickcom/tcpdf

ダウンロード後、下記フォルダ・ファイルを抜き出して「tcpdf」（名称任意）のフォルダ名で新規作成して入れておく
fonts
include
tcpdf_autoconfig.php
tcpdf_barcodes_1d.php
tcpdf_barcodes_2d.php
tcpdf_import.php
tcpdf_parser.php
tcpdf.php


FPDI: https://www.setasign.com/products/fpdi/downloads/
ダウンロード後、「src」フォルダを抜き出して「fpdi」（名称任意）の名前に書き換える

この2個のフォルダを「lib」（名称任意）というフォルダにまとめる。


### 全体のディレクトリを構成する

①全体のプロジェクトフォルダとして「tcpdf」（名称任意）作成」

②その中に先ほど作った「lib」フォルダとルートファイルの「index.php」と「receipt / receipt-pdf.php」「receipt / receipt.pdf」を作成

index.php　今回はここにフォームデータ入れます
receipt-pdf.php　流し込むための処理を書く
receipt.pdf 　流し込みテンプレートとなるファイル
※今回はサンプルとして領収書なのでreceiptにしています

□ index.phpを編集

```php
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
    <button type="submit">PDFを作成</button>
</form>
```

□ receipt-pdf.phpを編集

```php
<?php
// ライブラリ読み込み
require_once('../lib/tcpdf/tcpdf.php');
require_once('../lib/fpdi/autoload.php');

// ライブラリインスタンス化
$pdf = new setasign\Fpdi\Tcpdf\Fpdi('P', 'mm', [210, 297], true, 'UTF-8', false);

// $pdf->SetMargins(0, 0, 0); //マージン無効
$pdf->SetAutoPageBreak(false); //自動改ページ無効
$pdf->setPrintHeader(false); //ヘッダー無効　trueにすると線が表示
$pdf->setPrintFooter(false); //フッター無効　trueにすると線が表示

$pdf->setSourceFile("receipt.pdf"); // テンプレートファイル指定
$pdf->AddPage();
$tpl = $pdf->importPage(1);
$pdf->useTemplate($tpl);

// フォームから送られてくる値受け取り
$number = $_POST["number"];
$name = $_POST["name"];
$price = $_POST["price"];
$proviso = $_POST["proviso"];

//$pdf->SetFont('kozminproregular', スタイル, サイズ);
//$pdf->Text(x座標, y座標, テキスト);

//No.
$pdf->SetFont('kozminproregular', '', 11);
$pdf->Text(150, 11, htmlspecialchars( $number ) );

//名前
$pdf->SetFont('kozminproregular', '', 28);
$pdf->Text(15, 35, htmlspecialchars( $name ) );

//金額
$pdf->SetFont('kozminproregular', '', 40);
$price = number_format($price) . "-";
$pdf->Text(68, 70, htmlspecialchars( $price ) );

//但し書き
$pdf->SetFont('kozminproregular', '', 11);
$pdf->Text(70, 90, htmlspecialchars( $proviso ) );

//日付
$pdf->SetFont('kozminproregular', '', 11);
$today = date("Y年m月d日");
$pdf->Text(150, 21, $today);

//$pdf->Output(出力時のファイル名, 出力モード);
$pdf->Output("output.pdf", "I");
```