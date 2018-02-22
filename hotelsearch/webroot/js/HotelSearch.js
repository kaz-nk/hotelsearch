$(function() {
	/**
	 * 初期処理_非活性制御
	 */
	$(document).ready(function() {
		if ($('#hotelname').val() != "") {
			$('#prefectures').prop('disabled', true);
		} else if ($('#prefectures').val() != "") {
			$('#hotelname').prop('disabled', true);
		}
	});

	/**
	 * フォーカスアウト_非活性制御
	 */
	$('#hotelname').focusin(function(e) {
		$('#prefectures').prop('disabled', true);
	}).focusout(function(e) {
		if ($('#hotelname').val() == "") {
			$('#prefectures').prop('disabled', false);
		}
	});
	$('#prefectures').focusin(function(e) {
		$('#hotelname').prop('disabled', true);
	}).focusout(function(e) {
		if ($('#prefectures').val() == "") {
			$('#hotelname').prop('disabled', false);
		}
	});

	/**
	 * Planデータ取得処理
	 */
	$.ajax({
		type : 'POST',
		datatype : 'xml',
		url : "/HotelSearch/getPlan",
		success : function(data, status) {
			// TODO:dataに''値が入って取得できない
			// alert(data);
		},
		/**
		 * Ajax通信が失敗した場合に呼び出されるメソッド
		 */
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			alert('Error : ' + errorThrown);
		}
	});

});
