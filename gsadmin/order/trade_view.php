<? 
$mod	= "order";	
$menu	= $trade_stat;
include('../header.php');
$trade_stat = $db->object("cs_trade", "where idx=$idx");
?>
<script language="JavaScript">
<!--
function sendit(){
	var choose = confirm('주문정보를 수정 하시겠습니까?');
	if(choose) {	document.trade_form.submit(); }
}
//-->
</script>
<script type="text/javascript">
	function tradeDeli(){
		var form=document.trade_form;
		if(form.trade_delivery.value==6){
				document.getElementById("deliveryName").style.display="";
				document.getElementById("deliveryURL").style.display="";
		}else{
				document.getElementById("deliveryName").style.display="none";
				document.getElementById("deliveryURL").style.display="none";
		}
	}
</script>
	<div class="text-right">
		<h3 class="page-header">
			<small>주문관리</small>
		</h3>
	</div>

	<div class="text-right">
		<a href="javascript:;" class="btn btn-success btn-sm" onClick="openOderprint('<?=$trade_stat->trade_code;?>');"><i class="glyphicon glyphicon-print"></i> 주문내역</a>
	</div>

	<div class="page-header" style="font-weight:bold"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> 주문정보</div>
	<table class="table table-bordered">
	<colgroup>
	<col width="10%">
	<col width="15%">
	<col width="10%">
	<col width="15%">
	<col width="10%">
	<col width="15%">
	<col width="10%">
	<col width="15%">
	</colgroup>
	<tbody>
	<tr>
		<th>주문번호</th>
		<td class="text-center"><?=$trade_stat->trade_code;?></td>
		<th>주문접수일</th>
		<td class="text-center"><?=$trade_stat->trade_day;?></td>
		<th>회원ID</th>
		<td class="text-center"><? if($trade_stat->userid) {?><font color="#FF0000"><b><?=$trade_stat->userid;?></b></font><?} else {?><font color="#FF9933">비회원</font><?}?></td>
		<th>거래상태</td>
		<td class="text-center">
			<? if($trade_stat->trade_stat==1) {?>
				결제대기
			<?} else if($trade_stat->trade_stat==2) {?>
				결제완료
			<?} else if($trade_stat->trade_stat==3) {?>
				상품배송중
			<?} else if($trade_stat->trade_stat==4) {?>
				배송완료
			<?} else if($trade_stat->trade_stat==5) {?>
				주문취소
			<?} else {?>
				전체보기
			<?}?>
		</td>
	</tr>
	</tbody>
	</table><br>


	<div class="page-header" style="font-weight:bold"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> 주문내역</div>
	<table class="table table-bordered">
	<colgroup>
	<col width="*">
	<!-- <col width="50%"> -->
	<col width="10%">
	<col width="10%">
	<col width="10%">
	</colgroup>
	<thead>
	<tr>
		<th>상품명</th>
		<!-- <th>옵 션</th> -->
		<th>가 격</th>
		<th>수 량</th>
		<th>구매금액</th>
	</tr>
	</thead>
	<tbody>
	<?
	$trade_goods_result=$db->select("cs_trade_goods", "where trade_code='$trade_stat->trade_code' order by idx asc");
	while( $trade_goods_row=@mysql_fetch_object( $trade_goods_result)) {
	?>
	<tr>
		<td class="text-center"> <?=$db->stripSlash($trade_goods_row->goods_name);?></td>
		<!-- <td class="text-center">
		<? if($trade_goods_row->option1_part) {?>
		<?=$db->stripSlash($trade_goods_row->option1_name);?>: <?=$db->stripSlash($trade_goods_row->option1_part);?>
		<? }?>
		<? if($trade_goods_row->option2_part) {?>
		/ <?=$db->stripSlash($trade_goods_row->option2_name);?>: <?=$db->stripSlash($trade_goods_row->option2_part);?>
		<?}?>
		</td> -->
		<td class="text-center"> <?=number_format($trade_goods_row->goods_price);?> 원</td>
		<td class="text-center"> <?=number_format($trade_goods_row->goods_cnt);?> </td>
		<td class="text-center"> <?=number_format($trade_goods_row->goods_price*$trade_goods_row->goods_cnt);?> 원</td>
	</tr>
	<?}?>
	</tbody>
	</table>

	
	<table class="table table-bordered">
	<colgroup>
	<col width="15%">
	<col width="20%">
	<col width="15%">
	<col width="20%">
	<col width="15%">
	<col width="*">
	</colgroup>
	<tbody>
	<tr>
		<th>상품 금액</th>
		<td class="text-center"><?=number_format($trade_stat->trade_price);?> 원</td>
		<th>배송비</th>
		<td class="text-center"><?=number_format($trade_stat->trade_deliv_price);?> 원</td>
		<th rowspan="2">최종<br>결제 금액</th>
		<td rowspan="2" class="text-center"><?=number_format($trade_stat->trade_total_price);?> 원</td>
	</tr>
	<tr>
		<th>적립금</th>
		<td class="text-center">
			<? if($trade_stat->userid) {?>
				<?=number_format($trade_stat->trade_save_point);?> 원
			<?} else {?>
				<font color="#FF9933">비회원</font>
			<?}?>
		</td>
		<th rowspan="2">적립금 사용</th>
		<td rowspan="2" class="text-center"><?=number_format($trade_stat->trade_use_point);?> 원</td>
	</tr>
	</tbody>
	</table><br>


	<div class="page-header" style="font-weight:bold"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> 배송지정보</div>
	<form name="trade_form" method="post" action="trade_view_ok.php">
	<input type="hidden" name="idx" value="<?=$_GET['idx']?>">
	<input type="hidden" name="trade_stat" value="<?=$_GET['trade_stat']?>">
	<input type="hidden" name="search_trade_stat" value="<?=$_GET['search_trade_stat']?>">
	<input type="hidden" name="search_trade_method" value="<?=$_GET['search_trade_method']?>">
	<input type="hidden" name="search_sday" value="<?=$_GET['search_sday']?>">
	<input type="hidden" name="search_eday" value="<?=$_GET['search_eday']?>">
	<input type="hidden" name="search_item" value="<?=$_GET['search_item']?>">
	<input type="hidden" name="search_order" value="<?=$_GET['search_order']?>">
	<table class="table table-bordered">
	<colgroup>
	<col width="15%">
	<col width="35%">
	<col width="15%">
	<col width="35%">
	</colgroup>
	<tbody>
	<tr>
		<th>이 름</th>
		<td><input type="text" name="name" class="form-control col-md-5 input-sm" value="<?=$trade_stat->name;?>"></td>
		<th>연락처</th>
		<td><?$phone = explode("-",$trade_stat->phone);?>
			<input name="phone1" type="text" class="form-control2 input-sm text-center" size="4" maxlength="3" value="<?=$phone[0]?>"> - 
			<input name="phone2" type="text" class="form-control2 input-sm text-center" size="4" maxlength="4" value="<?=$phone[1]?>"> - 
			<input name="phone3" type="text" class="form-control2 input-sm text-center" size="4" maxlength="4" value="<?=$phone[2]?>">
		</td>
	</tr>
	<tr>
		<th>이메일</th>
		<td colspan="3"><input type="text" name="email" class="form-control input-sm" value="<?=$trade_stat->email;?>"></td>
	</tr>
	<tr>
		<th>주소</th>
		<td colspan="3">
			<input name="zip_new" id="zip_new" type="text" class="form-control2 input-sm text-center" value="<?=$trade_stat->zip_new;?>" size="10" readonly>&nbsp;
			<a href="javascript:;" class="btn btn-success btn-xs" onClick="openDaumPostcode();">우편번호찾기</a><br><br>
			<input name="add1" id="add1" type="text" class="form-control input-sm btn-block" value="<?=$trade_stat->add1;?>">
			<input name="add2" id="add2" type="text" class="form-control input-sm btn-block" value="<?=$trade_stat->add2;?>">
		</td>
	</tr>
	<tr>
		<th>배송메세지</th>
		<td colspan="3"><textarea type="text" name="content" class="form-control input-sm" rows="5"><?=$trade_stat->content;?></textarea></td>
	</tr>
	<tr>
		<th>택배사</th>
		<td colspan="3">
			<select name="trade_delivery" id="trade_delivery" onchange="tradeDeli();" class="form-control2 input-sm">
				<option value="">선택</option>
				<option value="1" <?if($trade_stat->trade_delivery==1){?>selected<?}?>>로젠택배</option>
				<option value="2" <?if($trade_stat->trade_delivery==2){?>selected<?}?>>CJ대한통운 택배</option>
				<option value="3" <?if($trade_stat->trade_delivery==3){?>selected<?}?>>한진택배</option>
				<option value="4" <?if($trade_stat->trade_delivery==4){?>selected<?}?>>우체국택배</option>
				<option value="5" <?if($trade_stat->trade_delivery==5){?>selected<?}?>>KGB택배</option>
				<option value="7" <?if($trade_row->trade_delivery==7){?>selected<?}?>>현대택배</option>
				<option value="8" <?if($trade_row->trade_delivery==8){?>selected<?}?>>대한통운</option>
				<option value="9" <?if($trade_row->trade_delivery==9){?>selected<?}?>>한진화물</option>
				<option value="10" <?if($trade_row->trade_delivery==10){?>selected<?}?>>옐로우택배</option>
				<option value="11" <?if($trade_row->trade_delivery==11){?>selected<?}?>>대신택배</option>
				<option value="12" <?if($trade_row->trade_delivery==12){?>selected<?}?>>경동택배</option>
				<option value="13" <?if($trade_row->trade_delivery==13){?>selected<?}?>>일양택배</option>
				<option value="14" <?if($trade_row->trade_delivery==14){?>selected<?}?>>이노지스</option>
				<option value="15" <?if($trade_row->trade_delivery==15){?>selected<?}?>>천일화물택배</option>
				<option value="16" <?if($trade_row->trade_delivery==16){?>selected<?}?>>건영택배</option>
				<option value="17" <?if($trade_row->trade_delivery==17){?>selected<?}?>>스마일로지스</option>
				<option value="18" <?if($trade_row->trade_delivery==18){?>selected<?}?>>편의점택배</option>
				<option value="6" <?if($trade_stat->trade_delivery==6){?>selected<?}?>>기타</option>
			</select>
		</td>
	</tr>
	<tr  id="deliveryName" style="display:none;">
		<th>택배사명</th>
		<td colspan="3"><input type="text" name="trade_delivery2" class="form-control input-sm col-md-3" value="<?=$trade_stat->trade_delivery2;?>"></td>
	</tr>
	<tr  id="deliveryURL" style="display:none;">
		<th>택배사주소(URL)</th>
		<td colspan="3"><input type="text" name="delivery_url" class="form-control input-sm" value="<?=$trade_stat->delivery_url;?>"></td>
	</tr>
	<tr>
		<th>송장번호</th>
		<td colspan="3" ><input type="text" name="trade_number" class="form-control input-sm" value="<?=$trade_stat->trade_number;?>"></td>
	</tr>
	</tbody>
	</table>
	</form><br>


	<div class="page-header" style="font-weight:bold"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> 결제정보</div>
	<table class="table table-bordered">
	<colgroup>
	<col width="15%">
	<col width="35%">
	<col width="15%">
	<col width="35%">
	</colgroup>
	<tbody>
	<tr>
		<th>결제정보</th>
		<td colspan="3">
			<?
			if($trade_stat->trade_method==1){
				$trade_method_info = explode("|",$trade_stat->trade_method_info);
				echo "무통장입금";
			}else if($trade_stat->trade_method==2){
				echo "신용카드";
			}else if($trade_stat->trade_method==3){
				echo "실시간 계좌이체";
			}else if($trade_stat->trade_method==10){
				echo "적립금";
			}
			?>
		</td>
	</tr>

	<?if($trade_stat->trade_method==1){?>
	<tr>
		<th>입금은행</th>
		<td colspan="3"><?echo $trade_method_info[0]?></td>
	</tr>
	<tr>
		<th>입금계좌</th>
		<td colspan="3"><?echo $trade_method_info[1]?>&nbsp;(예금주 : <?echo $trade_method_info[2]?>)</td>
	</tr>
	<tr>
		<th>현금영수증</th>
		<td colspan="3">
			<?
			if($trade_stat->tax_check==1){
				echo "개인소득공제용 : 휴대폰번호 (".$trade_stat->tax_phone.")";
			}else if($trade_stat->tax_check==2){
				echo "지출증빙용 : 사업자번호 (".$trade_stat->tax_licensee.")";
			}else{
				echo "미발행";
			}
			?>
		</td>
	</tr>
	<?}?>
	</tbody>
	</table><br>



	<div class="page-header" style="font-weight:bold"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> 주문처리일자</div>
	<table class="table table-bordered">
	<colgroup>
	<col width="15%">
	<col width="35%">
	<col width="15%">
	<col width="35%">
	</colgroup>
	<tbody>
	<tr>
		<th>결제완료</th>
		<td><?if(strtotime($trade_stat->trade_money_ok) > 1){echo $trade_stat->trade_money_ok;}else{echo "-";}?></td>
		<th>상품배송중</th>
		<td><?if(strtotime($trade_stat->delivery_day) > 1){echo $trade_stat->delivery_day;}else{echo "-";}?></td>
	</tr>
	<tr>
		<th>배송완료</th>
		<td><?if(strtotime($trade_stat->sale_day) > 1){echo $trade_stat->sale_day;}else{echo "-";}?></td>
		<th>주문취소</th>
		<td><?if(strtotime($trade_stat->cancle_day) > 1){echo $trade_stat->cancle_day;}else{echo "-";}?></td>
	</tr>
	</tbody>
	</table><br>


	<table class="table">
		<tr>
			<td class="text-center">
				<a href="javascript:;" class="btn btn-primary" onClick="sendit();">저장하기</a>&nbsp;&nbsp;
				<a href="#" class="btn btn-default" onClick="history.back();return false;">돌아기기</a>
			</td>
		</tr>
	</table>


<? include('../footer.php');?>