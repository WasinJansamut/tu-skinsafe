<?php

namespace App\Helpers;

use App\Models\ReportRateDriver;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class Helpers
{
    /**
     * คืนค่า view ที่มี prefix ซึ่งกำหนดจาก ENV ตัวแปร APP_VIEW_PREFIX
     *
     * ใช้เพื่อจัดการโครงสร้าง view ให้ยืดหยุ่น โดยสามารถเปลี่ยนโฟลเดอร์หลักของ view ได้จากไฟล์ .env
     * เช่น ถ้า APP_VIEW_PREFIX=cgm และเรียก prefixedView('bank_account.index')
     * จะได้ผลลัพธ์เท่ากับ view('cgm.bank_account.index')
     *
     * @param string $view ชื่อ view ที่ต้องการเรียก (โดยไม่ต้องใส่ prefix เอง)
     * @param array $data ข้อมูลที่ส่งไปยัง view
     * @param array $mergeData ข้อมูลเพิ่มเติมที่จะรวมกับ $data
     * @return \Illuminate\View\View
     */

    public static function versionedAsset($path)
    {
        $fullPath = public_path($path);
        $version = file_exists($fullPath) ? filemtime($fullPath) : time();
        return asset("{$path}") . '?v=' . $version;
    }

    // [Start] แปลงวันที่ ค.ศ. เป็น พ.ศ.
    public static function formatThaiDate($date)
    {
        try {
            $carbon_date = Carbon::parse($date);
            $year_th = $carbon_date->year + 543;

            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) { // วันที่ในรูปแบบ YYYY-MM-DD
                return $carbon_date->format('d/m/') . $year_th;
            } elseif (preg_match('/^\d{4}\/\d{2}\/\d{2}$/', $date)) { // วันที่ในรูปแบบ YYYY/MM/DD
                return $carbon_date->format('d/m/') . $year_th;
            } elseif (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $date)) { // วันที่และเวลารูปแบบ Y-m-d H:i:s
                return $carbon_date->format('d/m/') . $year_th . ' ' . $carbon_date->format('H:i:s') . ' น.';
            } elseif (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $date)) { // วันที่และเวลารูปแบบ Y-m-d H:i
                return $carbon_date->format('d/m/') . $year_th . ' ' . $carbon_date->format('H:i') . ' น.';
            } else {
                // return 'รูปแบบวันที่ไม่ถูกต้อง';
                return $date;
            }
        } catch (\Exception $e) {
            return 'รูปแบบวันที่ไม่ถูกต้อง';
        }
    }
    // [End] แปลงวันที่ ค.ศ. เป็น พ.ศ.

    // [Start] แปลงวันที่ ค.ศ. เป็น พ.ศ. แล้วแสดงเป็นข้อความแบบเดือนเต็ม
    public static function formatThaiDateText($date)
    {
        $month_th = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        $m = (int)Carbon::parse($date)->format('m');
        $day = (int)Carbon::parse($date)->format('d');
        $year = Carbon::parse($date)->year + 543;
        return $day . ' ' . $month_th[$m] . ' ' . $year;
    }
    // [End] แปลงวันที่ ค.ศ. เป็น พ.ศ. แล้วแสดงเป็นข้อความแบบเดือนเต็ม

    // [Start] แปลงวันที่ ค.ศ. เป็น พ.ศ. แล้วแสดงเป็นข้อความแบบเดือนย่อ
    public static function formatThaiDateTextShort($date)
    {
        $month_th = ["", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
        $m = (int)Carbon::parse($date)->format('m');
        $day = (int)Carbon::parse($date)->format('d');
        $year = Carbon::parse($date)->year + 543;
        return $day . ' ' . $month_th[$m] . ' ' . $year;
    }
    // [End] แปลงวันที่ ค.ศ. เป็น พ.ศ. แล้วแสดงเป็นข้อความแบบเดือนย่อ

    // [Start] อ่านจำนวนเงินเป็นอักษรภาษาไทย
    public static function convertAmountToThaiText($number)
    {
        if (is_numeric($number)) {
            $number = number_format($number, 2, '.', '');
            list($baht, $satang) = explode('.', $number);
            // Remove any non-numeric characters to prevent indexing errors
            $baht = preg_replace('/[^0-9]/', '', $baht);
            $satang = preg_replace('/[^0-9]/', '', $satang);
            if (strlen($baht) >= 1 && strlen($baht) <= 7) {
                $thaiNum = array('', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
                $unit = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');

                $bahtText = '';
                $len = strlen($baht);

                for ($i = 0; $i < $len; $i++) {
                    $n = $baht[$i];
                    if ($n != '0') {
                        if ($i == $len - 1 && $n == '1') {
                            $bahtText .= 'เอ็ด';
                        } elseif ($i == $len - 2 && $n == '2') {
                            $bahtText .= 'ยี่';
                        } elseif ($i == $len - 2 && $n == '1') {
                            $bahtText .= '';
                        } else {
                            if (isset($thaiNum[$n])) {
                                $bahtText .= $thaiNum[$n];
                            }
                        }
                        $bahtText .= $unit[$len - $i - 1];
                    }
                }

                if ($baht == '0') {
                    $bahtText = 'ศูนย์บาท';
                } else {
                    $bahtText .= 'บาท';
                }

                $satangText = '';
                if ($satang == '00') {
                    $satangText = 'ถ้วน';
                } else {
                    $len = strlen($satang);
                    for ($i = 0; $i < $len; $i++) {
                        $n = $satang[$i];
                        if ($n != '0') {
                            if ($i == $len - 1 && $n == '1') {
                                $satangText .= 'เอ็ด';
                            } elseif ($i == $len - 2 && $n == '2') {
                                $satangText .= 'ยี่';
                            } elseif ($i == $len - 2 && $n == '1') {
                                $satangText .= '';
                            } else {
                                if (isset($thaiNum[$n])) {
                                    $satangText .= $thaiNum[$n];
                                }
                            }
                            $satangText .= $unit[$len - $i - 1];
                        }
                    }
                    $satangText .= 'สตางค์';
                }
                return $bahtText . $satangText;
            } else {
                return 'เกิดข้อผิดพลาด : ค่าที่รับมาเกินหลักล้าน';
            }
        } else {
            return 'เกิดข้อผิดพลาด : ค่าที่รับมาไม่ใช่รูปแบบตัวเลข';
        }
    }
    // [End] อ่านจำนวนเงินเป็นอักษรภาษาไทย

    // [Start] อ่านจำนวนเงินเป็นอักษรภาษาอังกฤษ
    public static function convertAmountToEnglishText($number)
    {
        if (!is_numeric($number)) {
            return 'Invalid input';
        }

        $number = number_format($number, 2, '.', '');
        list($dollars, $cents) = explode('.', $number);

        $dollarsText = self::convertNumberToWords((int)$dollars);
        $centsText = self::convertNumberToWords((int)$cents);

        $result = '';

        if ((int)$dollars > 0) {
            $result .= ucfirst($dollarsText) . ' baht';
        }

        if ((int)$cents > 0) {
            $result .= ' and ' . $centsText . ' satang';
        } else {
            $result .= ' only';
        }

        return $result;
    }

    public static function convertNumberToWords($number)
    {
        // เดิมชื่อ numberToWords
        $dictionary = [
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety'
        ];

        $units = [
            1000000000 => 'billion',
            1000000    => 'million',
            1000       => 'thousand',
            100        => 'hundred'
        ];

        if ($number < 0) {
            return 'negative ' . self::convertNumberToWords(abs($number));
        }

        if ($number < 21) {
            return $dictionary[$number];
        }

        if ($number < 100) {
            $tens = ((int)($number / 10)) * 10;
            $unitsVal = $number % 10;
            return $dictionary[$tens] . ($unitsVal ? '-' . $dictionary[$unitsVal] : '');
        }

        foreach ($units as $divisor => $label) {
            if ($number >= $divisor) {
                $quotient = (int)($number / $divisor);
                $remainder = $number % $divisor;
                return self::convertNumberToWords($quotient) . ' ' . $label . ($remainder ? ' ' . self::convertNumberToWords($remainder) : '');
            }
        }

        return '';
    }
    // [End] อ่านจำนวนเงินเป็นอักษรภาษาอังกฤษ

    // Start หาระยะห่างของวันเวลาภาษาไทย
    public static function timeDifferenceInThai($start, $end)
    {
        // ใช้ Carbon เพื่อคำนวณระยะห่าง
        $diff = Carbon::parse($start)->diffForHumans(Carbon::parse($end), [
            'parts' => 3, // กำหนดให้แสดงส่วนต่าง 3 ส่วน เช่น 2 วัน 3 ชั่วโมง 10 นาที
            'join' => true,
            'syntax' => Carbon::DIFF_ABSOLUTE // เพื่อให้ไม่แสดง ago หรือ from now
        ]);

        // แปลงข้อความจากภาษาอังกฤษเป็นภาษาไทย
        $translations = [
            'seconds' => 'วินาที',
            'second' => 'วินาที',
            'minutes' => 'นาที',
            'minute' => 'นาที',
            'hours' => 'ชั่วโมง',
            'hour' => 'ชั่วโมง',
            'days' => 'วัน',
            'day' => 'วัน',
            'weeks' => 'สัปดาห์',
            'week' => 'สัปดาห์',
            'months' => 'เดือน',
            'month' => 'เดือน',
            'years' => 'ปี',
            'year' => 'ปี',
            'before' => 'ที่ผ่านมา',
            'after' => 'หลังจากนี้',
            'and' => '',
        ];

        // ทำการแทนที่ข้อความภาษาอังกฤษเป็นภาษาไทย
        foreach ($translations as $en => $th) {
            $diff = str_replace($en, $th, $diff);
        }

        return $diff;
    }
    // END  หาระยะห่างของวันเวลาภาษาไทย

    // [Start] เช็คว่ามีไฟล์รูปหรือไม่
    public static function checkImageExists($file)
    {
        try {
            if (File::exists(public_path("{$file}")) && !empty($file)) {
                return asset($file);
            } else {
                return asset('assets/images/no-image.png');
            }
        } catch (\Exception $e) {
            return asset('assets/images/no-image.png');
        }
    }
    // [End] เช็คว่ามีไฟล์รูปหรือไม่


    public static function getStatusName($statusCode)
    {
        $statusNames = [
            'CC' => 'ยกเลิก',
            'QT' => 'ใบเสนอราคา',
            'NS' => 'บิลขายใหม่',
            'DA' => 'รออนุมัติส่วนลด',
            'WS' => 'รอ Stock รับงาน',
            'PK' => 'กำลังจัดสินค้า',
            'CP' => 'รอลูกค้ารับหน้าร้าน',
            'RS' => 'เตรียมจัดส่ง',
            'IT' => 'กำลังจัดส่งสินค้า',
            'FD' => 'ส่งสินค้าไม่สำเร็จ',
            'AP' => 'ส่งเสร็จยังไม่ชำระ',
            'WC' => 'ส่งเสร็จ (รอเครดิต)',
            'SC' => 'รอตรวจสลิป',
            'AC' => 'รอบัญชียืนยันยอด',
            'DP' => 'ส่งแล้ว ชำระแล้ว',
        ];
        return $statusNames[$statusCode] ?? 'ไม่ทราบสถานะ';
    }
}
