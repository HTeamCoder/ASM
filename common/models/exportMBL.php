<?php
namespace common\models;
/**
 * @property \PHPExcel $objPHPExcel
 */
use backend\models\Chitietmbl;
use backend\models\MasterBillOfLoading;

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

/**
 * Class exportMBL
 * @package common\models
 * @property  MasterBillOfLoading $MBL
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

class exportMBL
{
    public $MBL;
    public $totalOfHBL = 0;
    //Document properties
    public $creator = 'Vicomtek';
    public $title = null;
    public $subject = 'HBL';
    public $description = '';
    public $category = '';
    public $lastModifiedBy = 'Vicomtek';
    public $keywords = '';
    public $sheetTitle = '';
    public $legal = 'Phan mem quan ly kho';
    public $landscapeDisplay = false;
    public $A4 = false;
    public $RTL = false;
    public $pageFooterText = '&RPage &P of &N';

    //config
    public $autoWidth = true;
    public $exportType = 'Excel5';
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

    public function renderHeader()
    {
        $mbl = $this->MBL;

        /**
         * @var  $mbl MasterBillOfLoading
         */
        self::$activeSheet->setCellValue("A1","MBL", true);
        self::$activeSheet->setCellValue("B1",$mbl->code_mbl, true);

        self::$activeSheet->setCellValue("A2","Port of loading", true);
        self::$activeSheet->setCellValue("B2",isset($mbl->portOfLoading->name)?$mbl->portOfLoading->name:"", true);

        self::$activeSheet->setCellValue("A3","Ocean vessel", true);
        self::$activeSheet->setCellValue("B3",isset($mbl->vessel->name)?$mbl->vessel->name:"", true);

        self::$activeSheet->setCellValue("A4","Voy No", true);
        self::$activeSheet->setCellValue("B4",$mbl->voy_no, true);

        self::$activeSheet->setCellValue("A5","HBL(s)", true);
        self::$activeSheet->setCellValue("B5",count($mbl->hbls), true);

        self::$activeSheet->setCellValue("A5","Container(s)", true);
        self::$activeSheet->setCellValue("B5",Chitietmbl::find()->where('id = :id', [':id' => $mbl->id])->one()->containers, true);

        self::$activeSheet->setCellValue("A7","STT", true);
        self::$activeSheet->setCellValue("B7","( House Bill )", true);
        self::$activeSheet->setCellValue("C7","DANH SÁCH CHỦ HÀNG ĐÓNG CHUNG CONTAINER", true);
        self::$activeSheet->setCellValue("D7","CONTAINER(S)", true);

        self::$activeSheet->setCellValue("E7","TÊN HÀNG", true);
        self::$activeSheet->setCellValue("F7","SỐ LƯỢNG", true);
        self::$activeSheet->setCellValue("G7","ĐƠN VỊ", true); // i->G
        self::$activeSheet->setCellValue("H7","TRỌNG LƯỢNG KGS", true); // G->H
        self::$activeSheet->setCellValue("I7","THỂ TÍCH", true); // H->J
        self::$activeSheet->setCellValue("J7","TOTAL", true); // H->J
        self::$activeSheet->setCellValue("K7","GHI CHÚ", true); // J->I
    }

    public function renderBody(){
        $mbl = $this->MBL;
        /**
         * @var $mbl MasterBillOfLoading
         */
        $dong = 8;
        foreach ($mbl->hbls as $hbl) {
            $this->totalOfHBL += $hbl->total;

            // STT
            self::$activeSheet->setCellValue("A$dong",$dong-7, true);
            // CODE HBL
            $codes = [];
            foreach ($hbl->codeHbls as $codeHbl) {
                $codes[] = $codeHbl->code;
            }

            $strCodes = implode('/',$codes);
            self::$activeSheet->setCellValueExplicit("B$dong",$strCodes, \PHPExcel_Cell_DataType::TYPE_STRING);

            //CONSIGNEE
            self::$activeSheet->setCellValue("C$dong",isset($hbl->consignee0->name)?$hbl->consignee0->name:"", true);

            // CONTAINERs



            // DESCRIPTIONS OF GOODS
            self::$activeSheet->setCellValue("E$dong",$hbl->description_of_goods, true);

            $soluong = 0;
            $trongluong = 0;
            $thetich = 0;
            $ghichu = "";
            $containers = [];

            foreach ($hbl->containerHbls as $containerHbl) {
                $soluong+= $containerHbl->packages;
                $trongluong+= $containerHbl->weight;
                $thetich+= $containerHbl->measurement;
                $ghichu = $containerHbl->package_remark;
                $nameContainer = $containerHbl->containerMbl->name.'/'.$containerHbl->containerMbl->seal;
                if(($type = $containerHbl->containerMbl->type)!="")
                    $nameContainer.='/'.$type;
                $containers[] = $nameContainer;
            }

            // CONTAINERS
            self::$activeSheet->setCellValue("D$dong",implode(",",$containers), true);

            if($ghichu != "")
                $ghichu = " ($ghichu)";

            $UnitPackage = isset($containerHbl->unitpakage->name)?$containerHbl->unitpakage->name:"";
            $UnitPackage .= $ghichu;

            // SL
            self::$activeSheet->setCellValue("F$dong",$soluong, true);

            // UNITPACKAGE
            self::$activeSheet->setCellValue("H$dong",$trongluong, true);

            // WEIGHT
            self::$activeSheet->setCellValue("G$dong",$UnitPackage, true);

            // MEAS
            self::$activeSheet->setCellValue("I$dong",$thetich, true);



            // TOTAL
            self::$activeSheet->setCellValue("J$dong",$hbl->total * $hbl->mbl->tygia, true);

            $dong++;
        }

        self::$activeSheet->setCellValue("A$dong",'TỔNG CỘNG', true);
        self::$activeSheet->setCellValue("J$dong",$this->totalOfHBL * $this->MBL->tygia, true);


    }

    public function run()
    {
        $this->renderHeader();
        $this->renderBody();
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
            ->setTitle("MBL {$this->MBL->code_mbl}")
            ->setCreator($this->creator)
            ->setSubject($this->subject)
            ->setDescription($this->legal)
            ->setCategory($this->category)
            ->setLastModifiedBy($this->lastModifiedBy)
            ->setKeywords($this->keywords);
        //create writer for saving
        $objWriter = \PHPExcel_IOFactory::createWriter(self::$objPHPExcel, $this->exportType);
        $this->filename = "MBL {$this->MBL->code_mbl}";
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
    
    public function renderExportButtons()
    {
        foreach ($this->exportButtons as $key => $button) {
            $item = is_array($button) ? CMap::mergeArray($this->mimeTypes[$key], $button) : $this->mimeTypes[$button];
            $type = is_array($button) ? $key : $button;
            $url = parse_url(Yii::app()->request->requestUri);
            //$content[] = CHtml::link($item['caption'], '?'.$url['query'].'exportType='.$type.'&'.$this->grid_mode_var.'=export');
            if (key_exists('query', $url)) {
                $content[] = CHtml::link($item['caption'], '?' . $url['query'] . '&exportType=' . $type . '&' . $this->grid_mode_var . '=export');          
            } else {
                $content[] = CHtml::link($item['caption'], '?exportType=' . $type . '&' . $this->grid_mode_var . '=export');				
            }
        }
        if ($content) {
            echo CHtml::tag('div', array('class' => $this->exportButtonsCSS), $this->exportText.implode(', ', $content));	
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