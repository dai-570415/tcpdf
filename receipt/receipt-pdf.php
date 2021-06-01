<?php
// ライブラリ読み込み
require_once('../lib/tcpdf/tcpdf.php');
require_once('../lib/fpdi/autoload.php');

// ライブラリインスタンス化
$pdf = new setasign\Fpdi\Tcpdf\Fpdi('L', 'mm', [128, 182], true, 'UTF-8', false);
// L 横　P 縦

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
$pdf->Text(130, 11, htmlspecialchars( $number ) );

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
$pdf->Text(130, 21, $today);

//$pdf->Output(出力時のファイル名, 出力モード);
$pdf->Output("output.pdf", "I");