//グローバル変数
var _useDevice="";//仕様デバイス
var _ini=0;//初期表示フラグ
var AllVals = new Array;//チェックボックス（カテゴリ）

//緯度経度情報
var _default_ido=36.559007;//
var _default_keido=136.652444;


//json（photo）データ格納エリア
var _records_photoid=new Array;
var _records_userid=new Array;
var _records_comment=new Array;
var _records_spotido=[];
var _records_spotkeido=[];
var _records_address=[];
var _records_datetime=new Array;//撮影日
var _records_img_url=new Array;//
var _records_updatetime=new Array;//更新日
var _records_categoryid=new Array;
var _records_categoryname=new Array;
var _records_nickname=new Array;

//photoデータ取得
function jsonGet(s_word){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //alert(s_word);
    $.ajax({
        type: "get",
        async: false,//同期
        url: "/json/" + s_word,
        dataType: "json",
        data:{'s_word':s_word,},
        //Ajax通信が成功した場合に呼び出されるメソッド
        success: function(data, dataType)
        {
            //返ってきたデータの表示
            //初期化
			_records_photoid=[];
			_records_userid=[];
			_records_comment=[];
			_records_updatetime=[];
			_records_category=[];
			_records_categoryname=[];
			_records_spotido=[];
			_records_place=[];
			_records_spotkeido=[];
			_records_img_url=[];
			_records_logo_url=[];
			_records_address=[];
			_records_datetime=[];
			_records_nickname=[];
			//値セット
            for (var i =0; i<data.length; i++){
                _records_photoid.push(data[i].id);
                _records_userid.push(data[i].user_id);
                _records_place.push(data[i].place);
                _records_category.push(data[i].category);
                _records_categoryname.push('いか');
                _records_spotido.push(data[i].latitude);
                _records_spotkeido.push(data[i].longitude);
                _records_address.push("アドレス");
                _records_img_url.push(data[i].img_url);
                _records_comment.push(data[i].comment);
                _records_datetime.push(data[i].datetime);
                _records_logo_url.push(data[i].logo_url);
                _records_updatetime.push(data[i].updatetime);
                _records_nickname.push(data[i].nickname);
                
            }
        },
        //Ajax通信が失敗場合に呼び出されるメソッド
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
             //通常はここでtextStatusやerrorThrownの値を見て処理を切り分けるか、単純に通信に失敗した際の処理を記述します。
             //alert('ajaxError : ' + errorThrown);
             alert(' マッピングを見る場合はログインしてください ');
        }
    });
}

//チェックボックスの配列作成
$(function() {
    $("#allcheck").hide();

    if(_ini==0){//初回表示の場合
        //カテゴリチェックボックス
		if (navigator.userAgent.indexOf("MSIE")!=-1 && navigator.userAgent.indexOf("Trident/4.0")!=-1){//IE
			var cnt = 0;//チェックボックス数
            for (e = 0; e < document.chbox.elements.length; e++){     //チェックボックスの数を数える
                if(document.chbox.elements[e].type == "checkbox")
                {
                    cnt++;
                }
            }
            for( i=0; i<cnt; i++ ){
              //チェックされているか確認する
              if( document.chbox.elements[i].checked ){
                //チェックボックスのvalue値を変数strに入れる
                AllVals.push(document.chbox.elements[i].value);
              }
            }
		}else{//not ie8
			$("input[name=service-checkbox]:checked").map(function() { //【カテゴリ】
				AllVals.push($(this).val());
			});
			$("input[name=service-checkbox2]:checked").map(function() { //【撮影年月】
				AllVals.push($(this).val());
			});
        }

        var url = new URL(window.location.href);
        var params = url.searchParams;
        var s_word=params.get('search'); // 5
        if(s_word === null){
            //文字検索なし
            //alert("null");
            s_word="nosearch";
        }else{//文字検索あり
            if(!s_word){
                //alert("kara");
                s_word="nosearch";
            }else{
                //alert("aaa");
            }
            
        }
        viewMap(s_word);
        _ini++;
    }

   //【カテゴリ】チェックボックスにチェックしたら、選択されているチェックボックス値を全て取得しマーカー立てる
   // $("input[name=service-checkbox]").click(function() {
    $("input[name=service-checkbox]").on("click",function() {
		//var AllVals = new Array;
        AllVals = new Array;
		if (navigator.userAgent.indexOf("MSIE")!=-1 && navigator.userAgent.indexOf("Trident/4.0")!=-1){
			var cnt = 0;//チェックボックス数
            for (e = 0; e < document.chbox.elements.length; e++){     //チェックボックスの数を数える
                if(document.chbox.elements[e].type == "checkbox")
                {
                    cnt++;
                }
            }
            for( i=0; i<cnt; i++ ){
              //チェックされているか確認する
              if( document.chbox.elements[i].checked ){
                //チェックボックスのvalue値を変数strに入れる
                AllVals.push(document.chbox.elements[i].value);
              }
            }
		}else{
			$("input[name=service-checkbox]:checked").map(function() { //【カテゴリ】
				AllVals.push($(this).val());
			});
			$("input[name=service-checkbox2]:checked").map(function() { //【撮影年月】
				AllVals.push($(this).val());
			});
        }
        //alert(2);
    	viewMap();
	});

    //【撮影年月】チェックボックスにチェックしたら、選択されているチェックボックス値を全て取得しマーカー立てる
    //$("input[name=service-checkbox2]").click(function() {
    $("input[name=service-checkbox2]").on("click",function() {
		//var AllVals = new Array;
        AllVals = new Array;
		if (navigator.userAgent.indexOf("MSIE")!=-1 && navigator.userAgent.indexOf("Trident/4.0")!=-1){
			var cnt = 0;//チェックボックス数
            for (e = 0; e < document.chbox.elements.length; e++){     //チェックボックスの数を数える
                if(document.chbox.elements[e].type == "checkbox")
                {
                    cnt++;
                }
            }
            for( i=0; i<cnt; i++ ){
              //チェックされているか確認する
              if( document.chbox.elements[i].checked ){
                //チェックボックスのvalue値を変数strに入れる
                AllVals.push(document.chbox.elements[i].value);
              }
            }
		}else{
			$("input[name=service-checkbox]:checked").map(function() { //【カテゴリ】
				AllVals.push($(this).val());
			});
			$("input[name=service-checkbox2]:checked").map(function() { //【撮影年月】
				AllVals.push($(this).val());
			});
        }
        //alert(3);
    	viewMap();
	});
});

function viewMap(s_word){
	//photoデータ読み込み
    //alert("aaaaaaaaaa");
    jsonGet(s_word);

    if(navigator.geolocation) {// Try W3C Geolocation (Preferred)
        browserSupportGetlocationFlag = true;
        navigator.geolocation.getCurrentPosition(function(position) {
            initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            nowlat = position.coords.latitude;
            nowlng = position.coords.longitude;
            //alert(nowlat);
            process_by_mode(nowlat,nowlng);//各処理
        }, function(error) {
                process_by_mode(_default_ido,_default_keido);//各処理
           }, {enableHighAccuracy : true ,timeout: 60000} // android
        );
    }
    else if (google.gears) {// Try Google Gears Geolocation
        browserSupportGetlocationFlag = true;
        var geo = google.gears.factory.create('beta.geolocation');
        geo.getCurrentPosition(function(position) {
            initialLocation = new google.maps.LatLng(position.latitude,position.longitude);//現在位置取得！
            nowlat = position.coords.latitude;
            nowlng = position.coords.longitude;
            //alert(222);
            process_by_mode(nowlat,nowlng);//各処理
        }, function(error) {//位置情報取得できなかった場合
            process_by_mode(_default_ido,_default_keido);//各処理
           }, {enableHighAccuracy:true,timeout: 60000} // android　高精度の位置情報を取得
        );
    }
    else {// Browser doesn't support Geolocation
        process_by_mode(_default_ido,_default_keido);//各処理
    }

    process_by_mode();

}

//掲載データよりGoogleMap上に表示するマーカーを設定
//function process_by_mode(posi,state) {


function process_by_mode(lat_now, lng_now) {

    //lat_now = _default_ido;//（緯度）
	//lng_now = _default_keido;//（経度）

	// グーグルマップの表示
	var map = new google.maps.Map(document.getElementById("mapDiv"), {
		zoom : 12,//15
		center : new google.maps.LatLng(lat_now, lng_now),
		mapTypeId : google.maps.MapTypeId.ROADMAP
	});
	// マーカークラスタ用のマーカー保存配列
	var markers = [];

	// 情報ウィンドウを生成
	var infowindow = new google.maps.InfoWindow();

	//マーカー作成し表示していく
    var old_ido=0;
    var old_keido=0;
    var content="";
	for(var l=0;l<_records_photoid.length;l++) {
       //alert(_records_photoid[l]+", "+_records_categoryname[l]+", "+_records_spotido[l]+", "+", "+_records_spotkeido[l]+", "+", "+_records_address[l]);
       
        if(l==0){
            old_ido=_records_spotido[l];
            old_keido=_records_spotkeido[l];
        }
        
        if(_records_spotido[l]!=old_ido || _records_spotkeido[l]!=old_keido){
            new setMarker(_records_logo_url[l-1], map, _records_spotido[l-1], _records_spotkeido[l-1], _records_place[l-1], _records_category[l-1], content);
            old_ido=_records_spotido[l];
            old_keido=_records_spotkeido[l];
            content="";
        }
        
        //データと選択されたチェックボックスのカテゴリが一致または撮影日が一致の場合は処理続行しマーカーを立てる。ただし初期表示時は何も表示しない。
        // if(AllVals.length==0){
	    //     break;
        // }

        // var isContinue = true;//チェックボックスで選択された値とデータが一致の場合処理続行
        // for(var s=0; s<AllVals.length; s++){//選択されたチェックボックス数分繰り返す(カテゴリチェック)
		//     if(_records_category[l]==AllVals[s]){
		// 	    isContinue=true;
		//         break;
    	// 	}else{
		//         isContinue=false;
    	// 	}
        // }
        // if(!isContinue){//一致しなかったものはスキップする
	    //     continue;
        // }
        // for(var s=0; s<AllVals.length; s++){//選択されたチェックボックス数分繰り返す（日付チェック）
        //     var satueiDate=_records_datetime[l].split(":");//撮影日(yyyy:mm:dd)の年別取得
		//     if(satueiDate[0]+satueiDate[1]==AllVals[s]){
		// 	    isContinue=true;
		//         break;
    	// 	}else{
		//         isContinue=false;
    	// 	}
        // }
        // if(!isContinue){//一致しなかったものはスキップする
	    //     continue;
        // }

	    //現在地からのルート案内
	    var url="";

		url    = "https://maps.google.com/maps?dirflg=d&saddr="+_default_ido+","+_default_keido+"&daddr="+_records_spotido[l]+","+_records_spotkeido[l];//中心から
	    //バルーン内コンテンツ作成
	    content += contentBuild(_records_logo_url[l-1], _records_comment[l], _records_photoid[l], _records_nickname[l], _records_datetime[l], _records_address[l], _records_place[l], url,  _records_img_url[l]);

	    //マーカーセット
        //new setMarker(map, _records_spotido[l], _records_spotkeido[l], _records_place[l], _records_category[l], content);
	}   //for
	
	//最終データ出力
    //alert(content);
	//if(content!=""){
		new setMarker(_records_logo_url[l-1], map, _records_spotido[l-1], _records_spotkeido[l-1], _records_place[l-1], _records_category[l-1], content);
    //}
    
    //バルーン内コンテンツ生成
    function contentBuild(logo_url, comment, photoid, nickname, datetime, address, place, url, img_url){

    	content = '<div>'+
    	              '<div>'+
    	                  '<p><a href="'+url+'" target="_blank">'+'<b>'+place+'</b>'+'</a></p>'+
                      '</div>'+
                      '<div id="outStyle">'+
		                      '<p><!--<img src="storage/images/img/'+logo_url+'" style="width:10%">-->'+nickname+'</p>'+
		                      '<p>日時：'+datetime+'</p>'+
		                      '<p><a rel="lightbox" href="http://127.0.0.1:8000/storage/images/'+img_url+'"><img id="imagePhoto" src="http://127.0.0.1:8000/storage/images/'+img_url+'"></a></p>'+
		                      //'<p>住所：'+address+'</p>'+
		                      '<p style="background: white;padding: 3%;text-align: left;color: gray;">'+comment+'</p>'+
                          '</div>'+
                      '</div>'+
                  '</div>';
        return content;
    }

	// マーカーを生成する
	function setMarker(logo_url, map, spotido, spotkeido, place, category, content) {
        
		var marker = new google.maps.Marker({
			position : new google.maps.LatLng(spotido, spotkeido),
			map : map,
			icon :
            { url: 'storage/images/img/'+logo_url,
                scaledSize : new google.maps.Size(25, 25)
            },
			title : place	// ツールチップにも場所名を表示
		});
		google.maps.event.addListener(marker, "click", function() {
			infowindow.open(map, marker);
			infowindow.setContent(content);
		});
	}
}
