<?php
$active_tid = 0; 
$active_atid = 0; 
$term_name = "";
if (isset($_GET["tid"])){
	$active_tid = $_GET["tid"];
}
if (isset($_GET["atid"])){
	$active_atid = $_GET["atid"];
}
?>
<header>
	<nav class="navbar  navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="brand" href="http://feodosia-leto.com">Feodosia-leto</a>
	        <ul class = "nav">
			
				<?php
				if ($active_tid == 0){
					print "<li class='active'>".l("Все", "feodosia_leto/arenda")."</li>"; 
				} else {
					print "<li>".l("Все", "feodosia_leto/arenda")."</li>"; 
				}
				foreach($tree as $item){

					if ($item->depth == 0) {
						$submenu = "";
						foreach($tree as $subitem){
							if ($subitem->parents[0] == $item->tid ) {
								if ($subitem->tid == $active_tid){
									$term_name =$item->name." > ".$subitem->name;
									$submenu .= "<li class='active'>".l($subitem->name, "feodosia_leto/arenda", array("query"=>array("tid"=>$subitem->tid)))."</li>";
								} else	{				
									$submenu .=  "<li>".l($subitem->name, "feodosia_leto/arenda", array("query"=>array("tid"=>$subitem->tid)))."</li>"; 
								}
							}
						}
						
						if (empty($submenu)){
							if ($item->tid == $active_tid){
								$term_name = $item->name;
								echo "<li class='active'>".l($item->name, "feodosia_leto/arenda", array("query"=>array("tid"=>$item->tid)))."</li>";
							} else	{				
								echo "<li>".l($item->name, "feodosia_leto/arenda", array("query"=>array("tid"=>$item->tid)))."</li>"; 
							}
						} else {
							
							$submenu = "<ul class='dropdown-menu'>$submenu</ul>";
							if ($item->tid == $active_tid){
								$term_name = $item->name;
								echo "<li class='active dropdown'><a href='feodosia_leto/arenda?tid={$item->tid}' class='dropdown-toggle' data-toggle='dropdown'>{$item->name}<b class='caret'></b></a>$submenu</li>";
							} else	{				
								echo "<li class='dropdown'><a href='feodosia_leto/arenda?tid={$item->tid}' class='dropdown-toggle' data-toggle='dropdown'>{$item->name}<b class='caret'></b></a>$submenu</li>";
							}
							
						}
						
					}
				}
				/* output $tree_city */
				$submenu = "";
				foreach($tree_city as $item){
					if ($item->depth == 0) {
						
						if ($item->tid == $active_tid){
								$term_name = $item->name;
								$submenu .= "<li class='active'>".l($item->name, "feodosia_leto/arenda", array("query"=>array("tid"=>$item->tid)))."</li>";
						} else	{				
								$submenu .= "<li>".l($item->name, "feodosia_leto/arenda", array("query"=>array("tid"=>$item->tid)))."</li>"; 
						}
					}	
				}					
				$submenu = "<ul class='dropdown-menu'>$submenu</ul>";
				$submenu = "<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>Пригород<b class='caret'></b></a>$submenu</li>";
				echo $submenu;	
				?>
			</ul>
		</div>
	</div>
	</nav>
</header>

<section class="container-fluid">
	<h2>Список недвижимости</h2>
	<h3><?php if (!empty($term_name)) { print $term_name; if ($active_atid > 0) echo " > "; }?> <?php foreach($areas as $item): if ($item->tid == $active_atid) echo $item->name; endforeach; ?></h3>		
	
	
	<div class="row-fluid">
		<div class="span12">
			<div class="informer-items pull-right">
				<div class="informer-item">
					<div class="status status-0 start"></div>
					<p>День заезда</p> 
				</div>
				<div class="informer-item">
					<div class="status status-1"></div>
					<p>Не оплачен</p> 
				</div>
				<div class="informer-item">
					<div class="status status-2 overdue"></div>
					<p>Оплата просрочена</p> 
				</div>
				<div class="informer-item">
					<div class="status status-2"></div>
					<p>Оплачен</p> 
				</div>
				<div class="informer-item">
					<div class="status status-3 end"></div>
					<p>День отьезда</p> 
				</div>
			</div>
			
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
		
		<div class="btn-group pull-right">
			<button class="btn">Район города</button>
			<button class="btn dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
			
			
			<?php
			//print_r($areas);
			$cur_tid = "";
			$cur_tid = $_GET["tid"];
			
			
			foreach($areas as $items): 
				$name = explode(":", $items->name);
				if (count($name)>0){
					$name = $name[1];
				} else {
					$name = $items->name;
				}
				if ($cur_tid == ""):?>
					<li><?php echo l($name, "feodosia_leto/arenda", array("query"=>array("atid"=>$items->tid))); ?></li>
				<?php else: ?>
					<li><?php echo l($name, "feodosia_leto/arenda", array("query"=>array("tid"=>$cur_tid, "atid"=>$items->tid))); ?></li>
				<?php endif; ?>	
			<?php endforeach; ?>
			</ul>
			
		</div>
		
		
			
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
		<div class="btn-group pull-right">
		  <button class="chenge-month btn active" data-value="0">Все</button>
		  <button class="chenge-month btn" data-value="5">Май</button>
		  <button class="chenge-month btn" data-value="6">Июнь</button>
		  <button class="chenge-month btn" data-value="7">Июль</button>
		  <button class="chenge-month btn" data-value="8">Август</button>
		  <button class="chenge-month btn" data-value="9">Сентябрь</button>
		</div>
			
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
		<form id="f_form" class="pull-right form-inline">
			<label><b>Найти свободный вариант</b></label>
			 <input type="date" name="f_start" id="f_start">
			 <input type="date" name="f_end" id="f_end">
			 <input type="button" value="Очистить" class= "btn btn-primary" id="f_btn">
		</form>
		</div>
	</div>


	<table class="table table-hover table-striped table-bordered table-condensed" id="bootstrap-table" >
		<thead>
			<tr>
				<!--<th>#</th>-->
				<th class="col1 node-title">Вариант жилья</th>
			
				<th class="col2 graphic">График</th>
				
				<!--<th>Коментарий</th>-->
				<th class="col3">ФИО</th>
				<th class="col4">Инфо</th>
			</tr>
		</thead>
		<tbody>
		<?php $i=1; 
			foreach($rows as $item): ?>
			<tr>
				<td class="col1"><?php print l($item->title,"node/".$item->nid, array("attributes"=>array("target"=>"_blank"))); ?><!--<br><span class="address"><?php print $item->address; ?> </span>--> </td>
			
				<td class="col2 item-<?php echo $item->nid; ?>">
					<?php print $item->reserv; ?>
				</td>
				<td class="col3">
					<a href="#" class="edit-text" data-placement="left" data-type="textarea" data-pk="<?php echo $item->nid; ?>"  data-name="fio" data-original-title="ФИО и другая информация" data-url="ajax"><?php print $item->fio; ?></a>
				</td>
				<td class="col4">
					<a href="#" class=" btn info-edit" data-pk="<?php echo $item->nid; ?>"  data-name="info" data-url="ajax"><i class="icon-info-sign"></i></a>
				</td>
				
			</tr>
		<?php endforeach; ?>	
		</tbody>
	</table>
</section>	
<footer class="container-fluid">
	<div class="row-fluid">
		<div class="span12 pull-center"><hr/><div align="center">Feodosia-leto TM</div></div>
	</div>
</footer>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Добавить / Измениеть бронь</h3>
  </div>
  <div class="modal-body">
		<form class="form-horizontal">
		  <div class="control-group">
			<label class="control-label" for="date">Дата заезда</label>
			<div class="controls">
			   <input id="start_date" type="date" name="start_date" >
			    <input type="time" name="start_time" id="start_time" style="float: right;width: 105px;">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="end_date">Дата отезда</label>
			<div class="controls">
			  <input type="date" name="end_date" id="end_date">
			  <input type="time" name="end_time" id="end_time" style="float: right;width: 105px;">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="status">Статус бронирования</label>
			<div class="controls">
			  <select name="status" id="status">
				<option value=1 selected >Предварительная бронь</option>
				<option value=2>Забронирован</option>
				<option value=3>Жилье не сдается</option>
			  </select>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="delay">Оплатить до</label>
			<div class="controls">
			   <input type="date" name="delay" id="delay" min=0>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="editor">Редактор</label>
			<div class="controls">
			  <select name="editor" id="editor">
			  <?php $editors = explode(",",variable_get('fa_editor', "admin, user"));
			  foreach ($editors as $key=>$item): ?>
				<option value="<?php echo $key; ?>"><?php echo $item; ?></option>
			  <?php endforeach; ?>	
			  </select>
			</div>
		  </div>
		  <input type="hidden" id="nid" name="nid">	
		  <input type="hidden" id="hash" name="hash">
		</form>
  </div>
  <div class="modal-footer">
    <button class="btn delete" onclick = "deleteReserv()" >Удалить</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Отмена</button>
    <button class="btn btn-primary" onclick="saveReserve()" >Сохранить</button>
  </div>
</div>
<!-- Modal -->
<div id="ckModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Дополнительная информация</h3>
  </div>
  <div class="modal-body">
		<form class="form-horizontal">
		   <textarea id="info" name="info" ></textarea>
		  <input type="hidden" id="info-nid" name="nid">	
		</form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Отмена</button>
    <button class="btn btn-primary" onclick="saveInfo()" >Сохранить</button>
  </div>
</div>

<!--<script src="//cdn.ckeditor.com/4.4.7/full/ckeditor.js"></script>-->
<script src="//cdn.ckeditor.com/4.4.7/standard/ckeditor.js"></script>
<script>

$(document).ready(function () {
	$(".info-edit").bind("click", loadInfo);
	
	CKEDITOR.replace( 'info', {"height":450} );
	$.fn.modal.Constructor.prototype.enforceFocus = function () {
    modal_this = this
    $(document).on('focusin.modal', function (e) {
        if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length
        // add whatever conditions you need here:
        &&
        !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select') && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
            modal_this.$element.focus()
        }
    })
	};
	
	$(".chenge-month").click(function(){
		var val = $(this).data("value");
		$(".chenge-month").removeClass("active");
		$(this).addClass("active");
		if (val == 0) {
			$(".days").show();
		} else {
			$(".days").hide();
			$(".month-"+val).show();
		}
		
	});
	
	$(".day.not-reserved").bind("click", changeDay );
	$(".day.reserved").bind("click", loadReserve );
	$(".day.reserved.end").unbind("click").bind("click", changeDay );
	$(".day.start").unbind("click");
	
	$(".chenge-month.active").trigger("click");
});
function changeDay(e){
	e.preventDefault();
	$("#nid").val($(this).attr("data-nid"));
	$("#start_date").val($(this).attr("data-date")).attr("min",$(this).attr("data-date")); 
	$("#end_date").val($(this).attr("data-date")).attr("min",$(this).attr("data-date")); 
	$("#start_time").val("12:00"); 
	$("#end_time").val("12:00"); 
	$("#hash").val("");
	$('#myModal .btn.delete').hide();
	$('#myModalLabel').html("Добавить бронь");
	$('#myModal').modal('show');
	
}
function saveReserve(){
	var value = $("#myModal form").serialize();
	var pk = $("#nid").val();
	$.ajax({
	   type: "POST",
	   url: "ajax",
	   data: "opt=update&pk="+pk+"&"+value,
	   success: function(msg){
		   var obj = eval('(' + msg + ')');
		   if (obj.status =="success"){
			   $(".col2.item-"+pk).html(obj.data);
			   
			   $(".col2.item-"+pk+" .day.not-reserved").bind("click",changeDay);
			   $(".col2.item-"+pk+" .day.reserved").bind("click",loadReserve);
			   $(".col2.item-"+pk+" .day.reserved.end").unbind("click").bind("click", changeDay );
			   $(".col2.item-"+pk+" .day.start").unbind("click");
			   
			   $(".chenge-month.active").trigger("click");
			   $('#myModal').modal('hide');
			} else {
				alert(obj.data);
			}
	   }
	});

}
function loadReserve(){
	var pk = $(this).data("nid");
	var hash = $(this).data("hash");
	$.ajax({
	   type: "POST",
	   url: "ajax",
	   data: "opt=getbyhash&pk="+pk+"&hash="+hash,
	   success: function(msg){
		   
		    var obj = eval('(' + msg + ')');
			
			$("#nid").val(pk);
			$("#hash").val(hash);
			$("#start_date").val(obj.start_date).attr("min",obj.start_date); 
			$("#end_date").val(obj.end_date).attr("min",obj.end_date); 
			$("#start_time").val(obj.start_time); 
			$("#end_time").val(obj.end_time); 
			$("#status").val(obj.status); 
			$("#editor").val(obj.editor); 
			$('#myModalLabel').html("Изменить бронь");
			$('#myModal .btn.delete').show();
			$('#myModal').modal('show');
			
	   }
	});
	return false;
}
function deleteReserv(){
	var pk = $("#nid").val();
	var hash = $("#hash").val();
	if (confirm("Вы уверены, что хотите удалить бронь?")){
	$.ajax({
	   type: "POST",
	   url: "ajax",
	   data: "opt=delete&pk="+pk+"&hash="+hash,
	   success: function(msg){
		   
		    //var obj = eval('(' + msg + ')');
			
			$(".col2.item-"+pk).html(msg);
		
			$(".col2.item-"+pk+" .day.not-reserved").bind("click",changeDay);
			$(".col2.item-"+pk+" .day.reserved").bind("click",loadReserve);
			$(".col2.item-"+pk+" .day.reserved.end").unbind("click").bind("click", changeDay );
			$(".col2.item-"+pk+" .day.start").unbind("click");
			   
			$(".chenge-month.active").trigger("click");
		   
		    $('#myModal').modal('hide');
			
		
	   }
	});
	}

}


function loadInfo(){
	var pk = $(this).data("pk");
	$.ajax({
	   type: "POST",
	   url: "ajax",
	   data: "opt=getinfo&pk="+pk,
	   success: function(msg){
		    var obj = eval('(' + msg + ')');
			$("#info-nid").val(pk);
			CKEDITOR.instances.info.setData(obj.info);
			$('#ckModal').modal('show');
	   }
	});
		return false;
}

function saveInfo(){
	var pk = $("#info-nid").val();
	var val = CKEDITOR.instances.info.getData();
	$.ajax({
	   type: "POST",
	   url: "ajax",
	   data: { "pk": pk, "name":"info", "value":val},
	   dataType: "json",
	   success: function(msg){
		   $('#ckModal').modal('hide');
	   }
	});
	
}
</script>
