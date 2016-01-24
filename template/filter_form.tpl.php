<?php
/*
array(			"city"=>$city, 
				"types"=>$types,
				"bads"=>$bads,
				"area"=>$area,
				"etag"=>$etag,
				"beach"=>$beach,
				"seetime"=>$seetime,
				"technics"=>$technics,
				
			)
			*/
?>
<div id="loadingDiv" class="loading" >Loading&#8230;</div> 
<div class="header-filter-form flipped hidden-xs hidden-md hidden-sm">
	<div class="header-filter-form-btn"><span class="open">Быстрый подбор</span><span class="close"></span></div>
	<div class='header-filter-form-content'>
		<div class="row">
			<div class="col-lg-3 item-1">
				<div class="title">Месторасположения</div>
				<div class="content">
				  <?php foreach($city as $item): ?>
				   <div class="city-row">
				   <label for="cyty">
						<input type="radio" name="city" value="<?php print $item->tid; ?>" data-name="city">
						<?php print $item->name; ?>
					</label>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="col-lg-3 item-2">
				<div class="title">Тип жилья</div>
				<div class="content">
				<?php foreach($types as $item): ?>
				   <div class="type-row">
				   <label for="type">
						<input type="radio" name="type" value="<?php print $item->tid; ?>" data-name="type" data-tid="<?php print $item->tid; ?>" >
						<?php print $item->name; ?>
					</label>
					</div>
				<?php endforeach; ?>
					
				<?php foreach($subtypes as $key=>$item): ?>
					<?php if (count($item) >0): ?>
				    <div class="subtype-row subtype-row-<?php print $key; ?>">
					<label for="subtype-<?php print $key; ?>">Кол-во комнат</label>
						<select name="subtype-<?php print $key; ?>" data-name="type" data-parent="<?php print $key; ?>">
							<option value="0">Любое</option>
							<?php foreach($item as $sitem): ?>
								<option value="<?php print $sitem->tid; ?>"><?php print $sitem->name; ?></option>
							<?php endforeach; ?>
						</select>
				    </div>
					<?php endif; ?>
				<?php endforeach; ?>	
					
				</div>
			</div>
			<div class="col-lg-3 item-3">
				<div class="title">Характеристики</div>
				<div class="content">
					<!--<div class="opt-row">
						<label for="bads">Спальных мест</label>
						<select name="bads" data-name="bads">
						<option value="0">Любой</option>
							<?php foreach($bads as $item): ?>
								<option value="<?php print $item->tid; ?>" ><?php print $item->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>-->
					<div class="opt-row">
						<label for="area">Район города</label>
						<select name="area" data-name="area">
						<option value="0">Любой</option>
							<?php foreach($area as $item): ?>
							<?php $sname = split(":", $item->name); ?>
								<option value="<?php print $item->tid; ?>" ><?php print $sname[1]; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<!--<div class="opt-row">
						<label for="etag">Этаж</label>
						<select name="etag" data-name="etag">
						<option value="0">Любой</option>
							<?php foreach($etag as $item): ?>
								<option value="<?php print $item->tid; ?>" ><?php print $item->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>-->
					<div class="opt-row">
						<label for="beach">Пляж</label>
						<select name="beach" data-name="beach">
						<option value="0">Любой</option>
							<?php foreach($beach as $item): ?>
								<option value="<?php print $item->tid; ?>" ><?php print $item->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="opt-row">
						<label for="seetime">Расстояние до моря</label>
						<select id="seetime" name="seetime" data-name="seetime">
						<option value="0">Любое</option>
							<?php /* foreach($seetime as $item): ?>
								<option value="<?php print $item->tid; ?>" ><?php print $item->name; ?></option>
							<?php endforeach; */?>
							<?php for($i=5; $i < 40; $i+=5): ?>
								<option value="<?php print $i; ?>" ><?php print "до $i мин."; ?></option>
							<?php endfor; ?>
						</select>
					</div>
					
				</div>
			</div>
			<div class="col-lg-3 item-4">
				<div class="title">Бытовая техника</div>
				<div class="content">
				
					<?php foreach($technics as $item): ?>
					<?php $fields = term_fields_get_fields_values($item);
						  if ($fields["is_filter_show_value"] > 0): ?>
					<div class="opt-row">
						<label for="technics"><input type="checkbox" name="technics" value="<?php print $item->tid; ?>" data-name="technics">
						<?php print $item->name; ?>
						</label>
					</div>
					<?php endif; ?>
					<?php endforeach; ?>
				</div>
				<a class="h-btn submit" href="#">Подобрать жилье</a>
				<a class="h-btn reset" href="#">Сбросить</a>
			</div>
		</div>
	</div>
</div>
<script>

var getFilterFormState = function(){
	var $form = $("#views-exposed-form-realty-page-1");
	// city
	var area = $(".header-filter-form  .city-row input:checked").val();
	$form.find("#edit-city [value='"+area+"']").attr("selected", "selected");
	// type 
	var type = $(".header-filter-form  .type-row input:checked").val();
	
	if ($(".subtype-row-"+type).length){
		var stype = $(".subtype-row-"+type+" select").val();
		if (stype > 0) type = stype;
	}
	$form.find("#edit-type [value='"+type+"']").attr("selected", "selected");
	// propertys
	var propertis = [];
	$(".header-filter-form .opt-row select").each(function(){
		propertis.push($(this).val());
	});
	$(".header-filter-form  .opt-row input:checked").each(function(){
		propertis.push($(this).val());
	});
	$form.find("input:checked").prop("checked",false);
	for(var i =0; i < propertis.length; i++){ 
		$form.find("#edit-feature-"+propertis[i]).prop('checked', true);
	}
	var seetime = $(".header-filter-form .opt-row #seetime").val();
	if (seetime > 0){
		$form.find("#edit-seetime").val(seetime);
	} else {
		$form.find("#edit-seetime").val("");
	}
}
var setFilterFormState = function(){
	var $form = $("#views-exposed-form-realty-page-1");
	var res = false;
	// city
	var area = $form.find("#edit-city").val();
	
	if (area == "All"){
		$(".header-filter-form  .city-row input").prop("checked",false);	
	} else {
		res = true;
		$(".header-filter-form  .city-row input:radio[value='"+area+"']").prop("checked",true);	
	}
	// type 
	var type = $form.find("#edit-type").val();
	
	if (type == "All"){
		$(".header-filter-form  .type-row input:radio").prop("checked",false);
	} else {
		res = true;
		$(".header-filter-form  .type-row input:radio[value='"+type+"']").prop("checked",true);	
		$(".subtype-row-"+type).show();	
		$(".subtype-row select").each(function(){
			if ($(this).find("[value='"+type+"']").length){
				var pid = $(this).data("parent");
				$(".header-filter-form  .type-row input:radio[value='"+pid+"']").prop("checked",true);	
				$(".subtype-row-"+pid+" select [value='"+type+"']" ).attr("selected", "selected");	
				$(".subtype-row-"+pid).show();	
			}
		});
		
	}
	// propertys
	$form.find(".form-checkboxes input").each(function(){
		if ($(this).prop("checked")){
			res = true;
			var val = $(this).val();
			$(".header-filter-form .opt-row select [value='"+val+"']").attr("selected", "selected");	
			$(".header-filter-form .opt-row input:checkbox[value='"+val+"']").prop('checked', true);	
		}
	});
	// seetime
	var seetime = parseInt($.trim($form.find("#edit-seetime").val()));
	
	if (seetime > 0){
		res = true;
		
		$(".header-filter-form #seetime [value='"+seetime+"']").attr("selected", "selected");	
	
	}
	return res;
}
var $loading = $('#loadingDiv').hide();
$(document)
  .ajaxStart(function () {
    $loading.show();
  })
  .ajaxStop(function () {
    $loading.hide();
  });
  
$(document).ready(function(){
	

	// Show and select sub type 
	$(".type-row input").change(function(){
		var tid = $(this).data("tid");
		$(".subtype-row").hide();
		if ($(this).prop("checked")){
			$(".subtype-row-"+tid).show();	
		}
	});
	
	$(".header-filter-form .header-filter-form-btn .open").click(function(){
		$(".header-filter-form-content").slideDown("slow", function(){
			$(".header-filter-form").removeClass("flipped");
		});
		
	});
	
	$(".header-filter-form .header-filter-form-btn .close").click(function(){
		$(".header-filter-form-content").slideUp("slow", function(){
			$(".header-filter-form").addClass("flipped");
		});
		
	});
	$(".header-filter-form  .h-btn.reset").click(function(){
		
			$(".header-filter-form input").prop("checked",false);
			$(".header-filter-form select [value='0']").attr("selected", "selected");	
			$(".header-filter-form .subtype-row").hide();
			getFilterFormState();
			$("#edit-reset").trigger("click");
	});
	$(".header-filter-form  .h-btn.submit").click(function(){
		getFilterFormState();
		$("#edit-submit-realty").trigger("click");
		return false;
	});
	
	if (setFilterFormState()){
		$(".header-filter-form").removeClass("flipped");
	}
})
</script>