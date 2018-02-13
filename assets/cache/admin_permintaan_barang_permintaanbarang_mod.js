$('#permintaan_barang_tanggal_permintaan').datepicker({ dateFormat: 'yy-mm-dd'});
/*
$('#permintaan_barang_tanggal_selesai').datepicker({ 
beforeShowDay: function(date) { 
        var day = date.getDay();
        return [(day > 0 && day < 6), ''];
    } 
});
*/
// aktifkan setelah 2 minggu
$('#permintaan_barang_tanggal_selesai').datepicker({ 
minDate: +7,
dateFormat: 'yy-mm-dd'
});

$('#permintaan_barang_tanggal_permintaan').datepicker({ dateFormat: 'yy-mm-dd'});
/*
$('#permintaan_barang_tanggal_selesai').datepicker({ 
beforeShowDay: function(date) { 
        var day = date.getDay();
        return [(day > 0 && day < 6), ''];
    } 
});
*/
// aktifkan setelah 2 minggu
$('#permintaan_barang_tanggal_selesai').datepicker({ 
minDate: +7,
dateFormat: 'yy-mm-dd'
});

