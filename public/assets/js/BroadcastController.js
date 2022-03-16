$("body").append($("<div/>",{"id":"x-popup"}));
var popup_wa = $('#x-popup').dxPopup({
    width: 900,
    height: 700,
    title: 'Kirim WhatsApp',
    showCloseButton: true,
    contentTemplate: function (contentElement) {
      contentElement.css("padding","0");
      contentElement.append(
          $("<table/>",{"class":"table-form"}).append(
            $("<tr/>").append(
              $("<th/>",{"style":"width:30%"}).append("No WA"),
              $("<th/>").append("Nama Peserta"),
              $("<th/>",{"style":"width:20%"}).append("Status"),
            )
          ),
          $("<div/>",{"style":"height: calc(100% - 70px)"}) .append(         
            $("<table/>",{"class":"table-form"}).append(
              $("<tbody/>",{"id":"listNomor"})
            )
          ),
          $("<div/>",{"style":"position:relative;border-top:1px solid #ddd"}).append(
            $("<button/>",{"class":"btn btn-primary pull-right","id":"bkirim"}).html("Kirim")
          )
        
      )
    }
}).dxPopup('instance');


function showBroadcast(){
  popup_wa.show();
  $("#listNomor").html("");
  $.ajax({
      url: url_api,
      success: function(data) {
        $.each(data, function(i, item){
            if (item.djalur_ujian_lokasi!=null){
              $("#listNomor").append(
                $("<tr/>").append(
                  $("<td/>",{"style":"width:30%"}).append(item.daftar_hp_ortu),
                  $("<td/>").append(item.daftar_nama),
                  $("<td/>",{"class":"text-center bstatus_"+i, "style":"width:20%;"+((item.dnotif_kartu==null?"":item.dnotif_kartu==1?"color:white;background:green":"color:white;background:red"))}).append(
                    (item.dnotif_kartu==null?"":item.dnotif_kartu_ket)
                  ),
                )
              )
            }
          
        })
        $("#bkirim").off();
        $("#bkirim").on( "click", function(e){
          $.each(data, function(i, item){
            if (item.djalur_ujian_lokasi!=null && item.dnotif_kartu!=1){
              setTimeout(function() {
                  $resp = $.ajax({
                    url: url_api + "broadcast/" + item.djalur_id,
                    method: "POST",
                    cache: false,
                    dataType: "json",
                    async:false,
                    statusCode: {
                                  500: function() {
                                    alert("Data Gagal Disimpan");
                                  }
                              }
                  }).done(function(data){
                    console.log(data)
                  }).fail(function(err, status){
                    console.log(err)          
                  }).responseJSON;
                  
                  $(".bstatus_"+i).css("color","white");
                  if ($resp.success==1){
                    $(".bstatus_"+i).css("background","green");
                    $(".bstatus_"+i).html("OK")
                  }else{
                    $(".bstatus_"+i).css("background","red");
                    $(".bstatus_"+i).html("WA Tidak Ditemukan")          
                  }        
              }, 250 * i);
            }

            
            });
        });
      },
      error: function(e) {
        $("#listNomor").append(
          $("<tr/>").append(
            $("<td/>",{"class":"text-center"}).append("Data Tidak Ditemukan")
          )
        )
      },
      timeout: 180000
  });

  
}