<?php
namespace common\models;
/**
 * @property \PHPExcel $objPHPExcel
 */
use backend\models\HouseBill;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\VarDumper;

/**
* @author Nikola Kostadinov
* @license MIT License
* @version 0.3
* @link http://yiiframework.com/extension/eexcelview/
*
* @fork 0.33ab
* @forkversion 1.1
* @author A. Bennouna
* @organization tellibus.com
* @license MIT License
* @link https://github.com/tellibus/tlbExcelView
*/

/* Usage :
  $this->widget('application.components.widgets.tlbExcelView', array(
    'id'                   => 'some-grid',
    'dataProvider'         => $model->search(),
    'grid_mode'            => $production, // Same usage as EExcelView v0.33
    //'template'           => "{summary}\n{items}\n{exportbuttons}\n{pager}",
    'title'                => 'Some title - ' . date('d-m-Y - H-i-s'),
    'creator'              => 'Your Name',
    'subject'              => mb_convert_encoding('Something important with a date in French: ' . utf8_encode(strftime('%e %B %Y')), 'ISO-8859-1', 'UTF-8'),
    'description'          => mb_convert_encoding('Etat de production généré à la demande par l\'administrateur (some text in French).', 'ISO-8859-1', 'UTF-8'),
    'lastModifiedBy'       => 'Some Name',
    'sheetTitle'           => 'Report on ' . date('m-d-Y H-i'),
    'keywords'             => '',
    'category'             => '',
    'landscapeDisplay'     => true, // Default: false
    'A4'                   => true, // Default: false - ie : Letter (PHPExcel default)
    'RTL'                  => false, // Default: false
    'pageFooterText'       => '&RThis is page no. &P of &N pages', // Default: '&RPage &P of &N'
    'automaticSum'         => true, // Default: false
    'decimalSeparator'     => ',', // Default: '.'
    'thousandsSeparator'   => '.', // Default: ','
    //'displayZeros'       => false,
    //'zeroPlaceholder'    => '-',
    'sumLabel'             => 'Column totals:', // Default: 'Totals'
    'borderColor'          => '00FF00', // Default: '000000'
    'bgColor'              => 'FFFF00', // Default: 'FFFFFF'
    'textColor'            => 'FF0000', // Default: '000000'
    'rowHeight'            => 45, // Default: 15
    'headerBorderColor'    => 'FF0000', // Default: '000000'
    'headerBgColor'        => 'CCCCCC', // Default: 'CCCCCC'
    'headerTextColor'      => '0000FF', // Default: '000000'
    'headerHeight'         => 10, // Default: 20
    'footerBorderColor'    => '0000FF', // Default: '000000'
    'footerBgColor'        => '00FFCC', // Default: 'FFFFCC'
    'footerTextColor'      => 'FF00FF', // Default: '0000FF'
    'footerHeight'         => 50, // Default: 20
    'columns'              => $grid // an array of your CGridColumns
)); */

class exportHBL
{
    public $idHBL;
    public $codes;
    //Document properties
    public $creator = 'Vicomtek';
    public $title = 'House bill of lading';
    public $subject = 'HBL';
    public $description = '';
    public $category = '';
    public $lastModifiedBy = 'Vicomtek';
    public $keywords = '';
    public $sheetTitle = 'House bill of lading';
    public $legal = 'Phan mem quan ly kho';
    public $landscapeDisplay = false;
    public $A4 = false;
    public $RTL = false;
    public $pageFooterText = '&RPage &P of &N';

    //config
    public $autoWidth = true;
    public $exportType = 'Excel2007';
    public $disablePaging = true;
    public $filename = null; //export FileName
    public $stream = true; //stream to browser
    public $grid_mode = 'export'; //Whether to display grid ot export it to selected format. Possible values(grid, export)
    public $grid_mode_var = 'grid_mode'; //GET var for the grid mode

    //options
    public $automaticSum = false;
    public $sumLabel = 'Totals';
    public $decimalSeparator = '.';
    public $thousandsSeparator = ',';
    public $displayZeros = false;
    public $zeroPlaceholder = '-';
    public $border_style;
    public $borderColor = '000000';
    public $bgColor = 'FFFFFF';
    public $textColor = '000000';
    public $rowHeight = 15;
    public $headerBorderColor = '000000';
    public $headerBgColor = 'CCCCCC';
    public $headerTextColor = '000000';
    public $headerHeight = 20;
    public $footerBorderColor = '000000';
    public $footerBgColor = 'FFFFCC';
    public $footerTextColor = '0000FF';
    public $footerHeight = 20;
    public static $fill_solid;
    public static $papersize_A4;
    public static $orientation_landscape;
    public static $horizontal_center;
    public static $horizontal_right;
    public static $vertical_center;
    public static $horizontal_left;
    public static $style = array();
    public static $headerStyle = array();
    public static $footerStyle = array();
    public static $summableColumns = array();

    public static $objPHPExcel;
    public static $activeSheet;

    //buttons config
    public $exportButtonsCSS = 'summary';
    public $exportButtons = array('Excel2007');
    public $exportText = 'Export to: ';

    //callbacks
    public $onRenderHeaderCell = null;
    public $onRenderDataCell = null;
    public $onRenderFooterCell = null;
    
    //mime types used for streaming
    public $mimeTypes = array(
        'Excel5'	=> array(
            'Content-type'=>'application/vnd.ms-excel',
            'extension'=>'xls',
            'caption'=>'Excel(*.xls)',
        ),
        'Excel2007'	=> array(
            'Content-type'=>'application/vnd.ms-excel',
            'extension'=>'xlsx',
            'caption'=>'Excel(*.xlsx)',				
        ),
        'PDF'		=>array(
            'Content-type'=>'application/pdf',
            'extension'=>'pdf',
            'caption'=>'PDF(*.pdf)',								
        ),
        'HTML'		=>array(
            'Content-type'=>'text/html',
            'extension'=>'html',
            'caption'=>'HTML(*.html)',												
        ),
        'CSV'		=>array(
            'Content-type'=>'application/csv',			
            'extension'=>'csv',
            'caption'=>'CSV(*.csv)',												
        )
    );

    public function init()
    {
//        PHPExcel_Worksheet_PageSetup
        self::$papersize_A4 = \PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4;
        self::$orientation_landscape = \PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE;
        self::$fill_solid = \PHPExcel_Style_Fill::FILL_SOLID;
        if (!isset($this->border_style)) {
            $this->border_style = \PHPExcel_Style_Border::BORDER_THIN;
        }
        self::$horizontal_center = \PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        self::$horizontal_right = \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
        self::$horizontal_left = \PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
        self::$vertical_center = \PHPExcel_Style_Alignment::VERTICAL_CENTER;

            // Creating a workbook
        self::$objPHPExcel = new \PHPExcel();
        self::$objPHPExcel->createSheet()->setTitle('House bill of lading');
        self::$objPHPExcel->setActiveSheetIndexByName('House bill of lading');
        self::$activeSheet = self::$objPHPExcel->getActiveSheet();

            // Set some basic document properties
            if ($this->landscapeDisplay) {
                self::$activeSheet->getPageSetup()->setOrientation(self::$orientation_landscape);
            }

            if ($this->A4) {
                self::$activeSheet->getPageSetup()->setPaperSize(self::$papersize_A4);
            }

            if ($this->RTL) {
                self::$activeSheet->setRightToLeft(true);
            }

            self::$objPHPExcel->getProperties()
                ->setTitle($this->title)
                ->setCreator($this->creator)
                ->setSubject($this->subject)
                ->setDescription($this->description . ' // ' . $this->legal)
                ->setCategory($this->category)
                ->setLastModifiedBy($this->lastModifiedBy)
                ->setKeywords($this->keywords);

            // Initialize styles that will be used later
            self::$style = array(
                'borders' => array(
                    'allborders' => array(
                                        'style' => $this->border_style,
                                        'color' => array('rgb' => $this->borderColor),
                                    ),
                ),
                'fill' => array(
                    'type' => self::$fill_solid,
                    'color' => array('rgb' => $this->bgColor),
                ),
                'font' => array(
                    //'bold' => false,
                    'color' => array('rgb' => $this->textColor),
                )
            );
            self::$headerStyle = array(
                'borders' => array(
                    'allborders' => array(
                                        'style' => $this->border_style,
                                        'color' => array('rgb' => $this->headerBorderColor),
                                    ),
                ),
                'fill' => array(
                    'type' => self::$fill_solid,
                    'color' => array('rgb' => $this->headerBgColor),
                ),
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => $this->headerTextColor),
                )
            );
            self::$footerStyle = array(
                'borders' => array(
                    'allborders' => array(
                                        'style' => $this->border_style,
                                        'color' => array('rgb' => $this->footerBorderColor),
                                    ),
                ),
                'fill' => array(
                    'type' => self::$fill_solid,
                    'color' => array('rgb' => $this->footerBgColor),
                ),
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => $this->footerTextColor),
                )
            );

        return self::$activeSheet;
    }

    public function gopO(){
        self::$activeSheet->mergeCells("A2:F2");
        self::$activeSheet->mergeCells("A3:F3");
        self::$activeSheet->mergeCells("A8:A11");
        self::$activeSheet->mergeCells("B8:E8");
        self::$activeSheet->mergeCells("B9:B11");
        self::$activeSheet->mergeCells("C9:C11");
        self::$activeSheet->mergeCells("D9:D11");
        self::$activeSheet->mergeCells("E9:E11");
        self::$activeSheet->mergeCells("F8:F11");
        self::$activeSheet->mergeCells("G8:G11");
        self::$activeSheet->mergeCells("H8:H11");
        self::$activeSheet->mergeCells("I8:I11");
        self::$activeSheet->mergeCells("J8:K8");
        self::$activeSheet->mergeCells("J9:J11");
        self::$activeSheet->mergeCells("K9:K11");
        self::$activeSheet->mergeCells("L8:L11");
        self::$activeSheet->mergeCells("M8:N10");
        self::$activeSheet->mergeCells("O8:S8");
        self::$activeSheet->mergeCells("O9:O11");
        self::$activeSheet->mergeCells("P9:P11");
        self::$activeSheet->mergeCells("Q9:Q11");
        self::$activeSheet->mergeCells("R9:R11");
        self::$activeSheet->mergeCells("S9:S11");
        self::$activeSheet->mergeCells("T8:T11");
        self::$activeSheet->mergeCells("Q1:T1");
        self::$activeSheet->mergeCells("Q2:T3");
        self::$activeSheet->mergeCells("A5:T5");
        self::$activeSheet->mergeCells("A6:T6");
    }
    public function renderHeader()
    {
        self::$activeSheet->setCellValue("A1","VẬN ĐƠN GOM HÀNG", true);
        self::$activeSheet->setCellValue("A2","(House bill of lading)", true);
        self::$activeSheet->setCellValue("A3","Số hồ sơ\nDocument's No", true);
        self::$activeSheet->setCellValue("A4","Năm đăng ký hồ sơ\nDocument's Year", true);
        self::$activeSheet->setCellValue("A5","Chức năng chứng từ\nDocument's function", true);
        self::$activeSheet->setCellValue("A6","Người gửi hàng\nShipper", true);
        self::$activeSheet->setCellValue("A7","Người nhận hàng\nConsignee", true);
        self::$activeSheet->setCellValue("A8","Người được thông báo 1\nNotify Party 1", true);
        self::$activeSheet->setCellValue("A9","Người được thông báo 2\nNotify Party 2", true);
        self::$activeSheet->setCellValue("A10","Mã cảng chuyển tải/quá cảnh\nCode of Port of transhipment/transit", true);
        self::$activeSheet->setCellValue("A11","Mã cảng giao hàng/cảng đích\nFinal destination", true);
        self::$activeSheet->setCellValue("A12","Mã cảng xếp hàng\nCode of Port of Loading", true);
        self::$activeSheet->setCellValue("A13","Mã cảng dỡ hàng\nPort of unloading/discharging", true);
        self::$activeSheet->setCellValue("A14","Địa điểm giao hàng\nPlace of Delivery", true);
        self::$activeSheet->setCellValue("A15","Loại hàng\nCargo Type/Terms of Shipment", true);
        self::$activeSheet->setCellValue("A16","Số vận đơn\nBill of lading number", true);
        self::$activeSheet->setCellValue("A17","Ngày phát hành vận đơn\nDate of house bill of lading", true);
        self::$activeSheet->setCellValue("A18","Số vận đơn gốc\nMaster bill of lading number", true);
        self::$activeSheet->setCellValue("A19","Ngày phát hành vận đơn gốc*\nDate of master bill of lading", true);
        self::$activeSheet->setCellValue("A20","Ngày khởi hành\nDeparture date", true);
        self::$activeSheet->setCellValue("A21","Tổng số kiện\nNumber of packages", true);
        self::$activeSheet->setCellValue("A22","Loại kiện\nKind of packages", true);
        self::$activeSheet->setCellValue("A23","Ghi chú\nRemark", true);

        //Table
        self::$activeSheet->setCellValue("A25","Mã hàng\nHS code if avail", true);
        self::$activeSheet->setCellValue("B25","Mô tả hàng hóa*\nDescription of Goods", true);
        self::$activeSheet->setCellValue("C25","Tổng trọng lượng*\nGross weight", true);
        self::$activeSheet->setCellValue("D25","Kích thước/thể tích*\nDemension/tonnage", true);
        self::$activeSheet->setCellValue("E25","Số hiệu cont\nCont. number", true);
        self::$activeSheet->setCellValue("F25","Số seal cont\nSeal number", true);

        //Điền các thông tin tương ứng
        $hbl = HouseBill::findOne($this->idHBL);
        self::$activeSheet->setCellValue("B6",isset($hbl->shipper0->name)?$hbl->shipper0->name:"", true);
        self::$activeSheet
            ->getStyle('B7')
            ->getNumberFormat()
            ->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        self::$activeSheet->setCellValueExplicit("B7",isset($hbl->consignee0->name)?strip_tags($hbl->consignee0->name):"", \PHPExcel_Cell_DataType::TYPE_STRING);

        self::$activeSheet->setCellValue("B8",isset($hbl->notifyParty->name)?$hbl->notifyParty->name:"", true);

        self::$activeSheet->setCellValue("B11",isset($hbl->mbl->portOfDischarge->name)?myFuncs::getCode($hbl->mbl->portOfDischarge->name):"", true);
        self::$activeSheet->setCellValue("C11",isset($hbl->mbl->portOfDischarge->name)?$hbl->mbl->portOfDischarge->name:"", true);

        $maCangDich = "";
        $tenCangDich = "";
        if(isset($hbl->placeOfReceipt->name)){
            $maCangDich = myFuncs::getCode($hbl->placeOfReceipt->name);
            $tenCangDich = $hbl->placeOfReceipt->name;
        }
        else if(isset($hbl->mbl->portOfLoading->name)){
            $maCangDich = myFuncs::getCode($hbl->mbl->portOfLoading->name);
            $tenCangDich = $hbl->mbl->portOfLoading->name;
        }


        self::$activeSheet->setCellValue("B12",$maCangDich, true);
        self::$activeSheet->setCellValue("C12",$tenCangDich, true);

        self::$activeSheet->setCellValue("B13",isset($hbl->mbl->portOfDischarge->name)?myFuncs::getCode($hbl->mbl->portOfDischarge->name):"", true);
        self::$activeSheet->setCellValue("C13",isset($hbl->mbl->portOfDischarge->name)?$hbl->mbl->portOfDischarge->name:"", true);
        $part = "";
        $diaDiemGiaoHang = "";

        if(isset($hbl->part->friendlyname)){
            if($hbl->part->friendlyname == 'a-part-of-cont'){
                $part = 'CFS/CFS';
                $diaDiemGiaoHang = isset($hbl->placeOfDelivery->name)?$hbl->placeOfDelivery->name:$hbl->mbl->kho->name;
            }
            else if($hbl->part->friendlyname == 'full-cont'){
                $part = 'CY/CY';
                $diaDiemGiaoHang = isset($hbl->placeOfDelivery->name)?$hbl->placeOfDelivery->name:(isset($hbl->mbl->portOfDischarge->name)?$hbl->mbl->portOfDischarge->name:"");
            }
            else if(strpos($hbl->part->friendlyname,'full-cont-')!==false){
                $part = 'CFS/CY';
            }
        }

        self::$activeSheet->setCellValue("B14",$diaDiemGiaoHang, true);

        self::$activeSheet->setCellValue("B15",$part, true);

        self::$activeSheet->setCellValue("B16",isset($hbl->codeHbls[count($hbl->codeHbls)-1]->code)?$hbl->codeHbls[count($hbl->codeHbls)-1]->code:"", true);
        self::$activeSheet->setCellValue("B17",date("d/m/Y",strtotime($hbl->date_of_house_bill_of_lading)), true);
        self::$activeSheet->setCellValue("B18",isset($hbl->mbl->code_mbl)?$hbl->mbl->code_mbl:"", true);
        self::$activeSheet->setCellValue("B19",$hbl->mbl->date_of_master_bill_of_lading!=""?date("d/m/Y",strtotime($hbl->mbl->date_of_master_bill_of_lading)):"", true);
        self::$activeSheet->setCellValue("B20",$hbl->mbl->departure_date!=""?date("d/m/Y",strtotime($hbl->mbl->departure_date)):"", true);
        $packages = 0;
        $unitPackage = "";
        $weight = 0;
        $mea = 0;
        $containerName = [];
        $containerSeal = [];
        foreach ($hbl->containerHbls as $containerHbl) {
            $packages += $containerHbl->packages;
            $unitPackage = $containerHbl->unitpakage->tentrenemanifest;
            $weight += $containerHbl->weight;
            $mea += $containerHbl->measurement;
            $containerName[] = $containerHbl->containerMbl->name;
            $containerSeal[] = $containerHbl->containerMbl->seal;
        }

        self::$activeSheet->setCellValue("B21",$packages, true);
        self::$activeSheet->setCellValue("B22",$unitPackage, true);

        self::$activeSheet->setCellValue("B23",$hbl->remark, true);

        self::$activeSheet->setCellValue("B3",$hbl->mbl->mahoso, true);
        self::$activeSheet->setCellValue("B26",$hbl->description_of_goods, true);
        self::$activeSheet->setCellValue("C26",$weight, true);
        self::$activeSheet->setCellValue("D26",$mea, true);
        self::$activeSheet->setCellValue("E26",implode("\n",$containerName), true);
        self::$activeSheet->setCellValue("F26",implode("\n",$containerSeal), true);



        for($i=1; $i<=6; $i++)
            self::$activeSheet->getColumnDimension($this->columnName($i))->setWidth(30);

        self::$activeSheet->getStyle("A1:F26")
            ->getAlignment()
            ->setVertical(self::$vertical_center)
            ->setWrapText(true);

        self::$activeSheet->getStyle("A1:F26")->applyFromArray(
            array(
                'font' => array(
                    'name'  => 'Times New Roman',
                    'size'  => 13,
                ),
            )
        );
        self::$activeSheet->getStyle("A1:A2")->applyFromArray(
            array(
                'font' => array(
                    'bold' => true
                ),
            )
        );
        $styleBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        self::$activeSheet->getStyle("A3:B23")->applyFromArray($styleBorder);
        self::$activeSheet->getStyle("A1:F2")->applyFromArray($styleBorder);
        self::$activeSheet->mergeCells("A1:F1");
        self::$activeSheet->mergeCells("A2:F2");
        self::$activeSheet->getStyle("A1")->getAlignment()->setHorizontal(self::$horizontal_center);
        self::$activeSheet->getStyle("A2")->getAlignment()->setHorizontal(self::$horizontal_center);

        self::$activeSheet->getStyle("A25:F26")->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_DOUBLE
                    )
                )
            )
        );
    }

    public function run()
    {
        $this->renderHeader();
        self::$activeSheet
            ->getSheetView()->setZoomScale(100);
        self::$activeSheet->getHeaderFooter()
            ->setOddFooter('&L&B' . self::$objPHPExcel->getProperties()->getTitle() . $this->pageFooterText);

        self::$activeSheet->getPageSetup()
//                ->setPrintArea("A1:T10"/* . $this->columnName(count($this->columns)) . ($row + 2)*/)
            ->setFitToWidth();
        self::$activeSheet->getPageSetup()->setFitToPage(true);
        self::$activeSheet->getPageSetup()->setFitToWidth(1);
        self::$activeSheet->getPageSetup()->setFitToHeight(0);
        self::$activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(8,11);

        self::$activeSheet->getPageSetup()->setPaperSize(self::$papersize_A4);
        self::$activeSheet->getPageSetup()->setOrientation(self::$orientation_landscape);

        self::$activeSheet->getPageMargins()->setLeft(0.5)->setRight(0.5);
        self::$objPHPExcel->getProperties()
            ->setTitle("HBL {$this->codes}")
            ->setCreator($this->creator)
            ->setSubject($this->subject)
            ->setDescription($this->legal)
            ->setCategory($this->category)
            ->setLastModifiedBy($this->lastModifiedBy)
            ->setKeywords($this->keywords);
        //create writer for saving
        $objWriter = \PHPExcel_IOFactory::createWriter(self::$objPHPExcel, $this->exportType);
        $this->filename = "HBL {$this->codes}";
        if (!$this->stream) {
            $objWriter->save($this->filename);
        } else {
            //output to browser
            if(!$this->filename) {
                $this->filename = $this->title;
            }
            $this->cleanOutput();
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-type: '.$this->mimeTypes[$this->exportType]['Content-type']);
            header('Content-Disposition: attachment; filename="' . $this->filename . '.' . $this->mimeTypes[$this->exportType]['extension'] . '"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
            exit;
        }
    }

    /**
    * Returns the corresponding Excel column.(Abdul Rehman from yii forum)
    * 
    * @param int $index
    * @return string
    */
    public function columnName($index)
    {
        --$index;
        if (($index >= 0) && ($index < 26)) {
            return chr(ord('A') + $index);
        } else if ($index > 25) {
            return ($this->columnName($index / 26)) . ($this->columnName($index%26 + 1));
        } else {
            throw new Exception("Invalid Column # " . ($index + 1));
        }
    }

    /**
    * Performs cleaning on mutliple levels.
    * 
    * From le_top @ yiiframework.com
    * 
    */
    private static function cleanOutput() 
    {
        for ($level = ob_get_level(); $level > 0; --$level) {
            @ob_end_clean();
        }
    }
}