<?php

    function convert_date_time($value){
        return date('d F Y - H:i:s', strtotime($value));
    }

    function convert_date($value) {
        return date('d-M-Y', strtotime($value));
    }
     
    function convert_rupiah($value){
        return "Rp. " . number_format($value,0,',','.');
    }

    function notifications(){
    $transactions = \App\Models\Transaction::all();
    $data = [];

    foreach($transactions as $transaction){
        $now = \Carbon\Carbon::now();
        $date_end = $transaction->date_end;
        if($now > $date_end){
        $diff = \Carbon\Carbon::parse($transaction->date_end)->diffInDays($now);
        if($diff > 0 && $transaction->status == 0){
            $data[] = ['id' => $transaction->id, 'message' => $transaction->member->name.' melewati batas waktu '.$diff.' hari'];
        }
        }
    }
    return json_decode(json_encode($data)); // convert multi array to object
    }
?>