@extends('layout')

@section('content')
	<div class="container-fluid">
	    <div class="page-header">
	        <div class="row">
	            <div class="col-sm-12">
	            	<a href="{{url('todo')}}" class="action-back" title="BACK"><i class="fa fa-angle-left"></i></a>
	            	<div class="pull-left">
		                <h5 style="margin:0"><span id="x-title">{{$d->project_name}}</span></h5>
		                <p class="project_desc">{{$d->project_desc}}</p>
		            </div>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="container-fluid">
		<div id="todo_list" class="row ui-sortable">
			
		</div>
	</div>

	<div class="modal fade" id="card_form" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title">
							<input  type="text" class="todo_control todo_card_name" placeholder="Entry card name" name="sub_name" required="" />
							<textarea class="todo_control todo_card_desc" placeholder="Add card description..." row="3"></textarea>
						</h6>
						<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<ul class="xtab-button xtab-flex" style="border-bottom:1px solid #ddd">
						<li><a href="javascript:;" onclick="saveCard(this)"><i class="fa fa-save"></i> Save</a></li>
						<li><a href="javascript:;" onclick="removeCard(this)"><i class="fa fa-remove"></i> Remove</a></li>
					</ul>
					<div class="modal-body">
						<div style="display: flex">
							<span class="progress_text">0%</span>
							<div class="progress" style="height: 12px;flex:1">
		                        <div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
		                    </div>
						</div>
						
						<ul class="card_item">
							<li>
								<input class="checkbox_animated" type="checkbox" data-id=""> <input class="todo_control todo_card_item" value="Test" type="text" data-id="" onfocus="setOld(this)" onfocusout="setItemF(this)" onkeypress="setItem(event,this)">
							</li>
						</ul>

						<div class="card_add_button">
							<div class="card_add_form">
								<div style="display: flex">
									<input class="todo_control todo_card_item" id="new_item" placeholder="Add an item" type="text" onkeypress="setItem(event,this)">
									<a class="todo_card_item_button"  onclick="newCardItem(this)"><i class="fa fa-save"></i></a>
									<a class="todo_card_item_button" style="color:#333" onclick="removeCardItem(this)"><i class="fa fa-remove"></i></a>
								</div>
							</div>
							<a href="javascript:;" class="btn btn-info todo_card_item_add" onclick="addCardItem(this)"><i class="fa fa-plus"></i> Add item</a>
						</div>


					</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{asset('assets/plugins/dragable/sortable.js')}}"></script>
	<script>
		// (function($) {
		//   "use strict";
		//     Sortable.create(todo_list, {
		//       group: 'todo_list',
		//       animation: 150
		//     });
		// })(jQuery);
		//   $( function() {
		//     $( "#todo_list" ).sortable({
		//       revert: true,
		//       animation:150
		//     });
		//   }); 

		var todo=[];
		var list_id="";
		var card_id="";
		var base_url = "/api/todo/{{$d->project_id}}";
		var old = "";


		var newlist = function(e){
			$("#todo_list").append(
				$('<div class="col-lg-4 new">').append(
					$('<div class="card_todo">').append(
						$('<div class="todo_header">').append('<input type="text" placeholder="Enter List Title" class="todo_name" onkeypress="setList(event, this)"/>')
					).append(
					`<div class="todo_footer">
							<ul class="xtab-button xtab-flex">
								<li><a href="javascript:;" onclick="addList(this)">Add</a></li>
								<li><a href="javascript:;" onclick="newRemove(this)">Remove</a></li>
							</ul>
						</div>`
					)
				)
			)

			$("#addList").remove();
			$(".new .todo_name").focus();
		}

		var setList = function(e, el){
			 if (e.keyCode  == 13) {
				id = $(el).data("id");
				name = $(el).val();

				data = {"todo_name": name};

		  		if (id!=undefined){
		  			data.id = id;
		  		}
		  		if (name==""){
					$(el).focus();
				}else{
			  		$.ajax({
						url: base_url+"/set",
						method: "POST",
						cache: false,
						data: data,
						statusCode: {
							500: function() {
								alert("Data Not Saved.");
							}
						}
					}).done(function(resp){
						if (resp.success==1){
							getData();
						}else{
							alert(resp.message);
						}
					}).fail(function(xhr,status, err){
						error = err;
						alert("Data Not Saved.");
					})
				}

		    	return false;   
			 }
		}

		var addList = function(e){
			name = $(".new .todo_name").val().trim();

			if (name==""){
				$(".new .todo_name").focus();
			}else{
				$.ajax({
					url: base_url+"/set",
					method: "POST",
					cache: false,
					data: {"todo_name":name},
					statusCode: {
						500: function() {
							alert("Data Not Saved.");
						}
					}
				}).done(function(resp){
					if (resp.success==1){
						getData();
					}else{
						alert(resp.message);
					}
				}).fail(function(xhr,status, err){
					error = err;
					alert("Data Not Saved.");
				})
			}
		}

		var newRemove = function(e){
			$(".new").remove();
			$("#todo_list").append(addButton);

		}

		var addButton = function(){
			return `<div class="col-lg-4" id="addList">
				<div class="card_todo">
					<div class="todo_header">
						<a href="javascript:;" class="todo_add" onclick="newlist(this)"><i class="fa fa-plus"></i> Add List</a>
					</div>
				</div>
			</div>`;
		}

		var listRemove = function(e){
			id = $(e).data('id');

			if(confirm("Are you sure want delete this Todo List  ?")){
				$.ajax({
					url: base_url+"/delete/"+id,
					method: "POST",
					cache: false,
					statusCode: {
						500: function() {
							alert("Data was not deleted.");
						}
					}
				}).done(function(resp){
					if (resp.success==1){
						getData();
					}else{
						alert(resp.message);
					}
				}).fail(function(xhr,status, err){
					error = err;
					alert("Data was not deleted.");
				})
			}
		}

		//CARD
		$("#card_form").on('shown.bs.modal', function () {
			if (card_id==""){				
			    $('.todo_card_name').focus();
			}
		}).on('hidden.bs.modal',function(){
				list_id="";
				card_id="";
				getData();
		});
		var newCard = function(e){
			$(".todo_card_name").val("");
			$(".todo_card_desc").val("");
			$(".modal-body").hide();
			list_id = $(e).data("list");	

			$("#card_form").modal("show");		
		}

		function countProgress(){
			finish=0;
			sub=0;
			$(".card_item input[type=checkbox]").each(function(){
				if ($(this).is(':checked')) {
					finish++;
				}
				sub++;
			});

			progress = 0;
			if (sub>0){
				progress = (finish / sub)*100;				
			}

			$(".progress_text").html(progress+"%");
			$(".progress-bar").css("width",progress+"%");

		}


		var showCard = function(e){
			list_index = $(e).data("list-index");
			index = $(e).data("index");

			item = todo[list_index].todo_card[index];

			list_id = item.todo_parent;
			card_id = item.todo_id;

			$(".todo_card_name").val(item.todo_name);
			$(".todo_card_desc").val(item.todo_desc);
			getCardItem();

			$("#card_form").modal("show");

		}

		var saveCard = function(e){
			name = $(".todo_card_name").val().trim();
			desc = $(".todo_card_desc").val().trim();
			data = {"todo_name":name, "todo_desc":desc};
			if (card_id!=""){
				data.id = card_id;
			}

			if (list_id!=""){
				$.ajax({
					url: base_url+"/card/"+list_id+"/set",
					method: "POST",
					cache: false,
					data: data,
					statusCode: {
						500: function() {
							alert("Data Not Saved.");
						}
					}
				}).done(function(resp){
					if (resp.success==1){
						card_id = resp.data;
						getCardItem();
						$(".modal-body").show();
						getData();
					}else{
						alert(resp.message);
					}
				}).fail(function(xhr,status, err){
					error = err;
					alert("Data Not Saved.");
				})	
			}

		}

		var removeCard = function(e){
			if (card_id==""){
				$("#card_form").modal("hide");
			}else{

				if(confirm("Are you sure want delete this Card and all items ?")){
					$.ajax({
						url: base_url+"/card/"+ list_id +"/delete/"+card_id,
						method: "POST",
						cache: false,
						statusCode: {
							500: function() {
								alert("Data was not deleted.");
							}
						}
					}).done(function(resp){
						if (resp.success==1){
							$("#card_form").modal("hide");
						}else{
							alert(resp.message);
						}
					}).fail(function(xhr,status, err){
						error = err;
						alert("Data was not deleted.");
					})
				}
			}
		}

		//CARD ITEM



		var addCardItem = function(e){
			$(e).hide();
			$("#new_item").val("");
			$(".card_add_form").show();
			$("#new_item").focus();
		}




		var removeCardItem = function(e){
			id = $(e).data("id");

			if (id==undefined){
				$(".todo_card_item_add").show();
				$(".card_add_form").hide();

			}else{
				if(confirm("Are you sure want delete this Item  ?")){
					$.ajax({
						url: base_url+"/item/"+ card_id +"/delete/"+id,
						method: "POST",
						cache: false,
						statusCode: {
							500: function() {
								alert("Data was not deleted.");
							}
						}
					}).done(function(resp){
						if (resp.success==1){
							getCardItem();
						}else{
							alert(resp.message);
						}
					}).fail(function(xhr,status, err){
						error = err;
						alert("Data was not deleted.");
					})
				}
			}
		}

		var setOld = function(e){
			old = $(e).val();
		}

		var setItemF = function(e){
			val = $(e).val().trim();

			if (val==""){
				$(e).focus();
			}else{
				saveItem(e);
			}
		}

		var setItem = function(e, el){
			if (e.keyCode  == 13) {
				val = $(el).val().trim();

				if (val==""){
					$(el).focus();
				}else{
					saveItem(el);
				}
			}
		}

		var saveItem = function(e){
			id = $(e).data("id");
			name = $(e).val().trim();

			data = {"sub_name":name};
			if (id!=undefined){
				data.id = id;
			}

			if (card_id!="" && name!=""){
				if (old=="" || old!=name){
					$.ajax({
						url: base_url+"/item/"+card_id+"/set",
						method: "POST",
						cache: false,
						data: data,
						statusCode: {
							500: function() {
								alert("Data Not Saved.");
							}
						}
					}).done(function(resp){
						if (resp.success==1){
							$(".card_add_form").hide();
							$(".todo_card_item_add").show();
							getCardItem();
						}else{
							alert(resp.message);
						}
					}).fail(function(xhr,status, err){
						error = err;
						alert("Data Not Saved.");
					})	

				}			
			}

		}

		var setChecked = function(e){
			id = $(e).data("id");
			status = 0;
			if ($(e).is(':checked')) {
				status=1;
			}
			$.ajax({
				url: base_url+"/item/"+ card_id +"/checked/"+id,
				method: "POST",
				data:{status:status},
				cache: false,
			}).done(function(resp){
				if (resp.success!=1){
					 $(e).prop("checked",!$(e).is(':checked'));
					 alert(resp.message)
				}else{
					countProgress();
				}
			}).fail(function(xhr,status, err){
				$(e).prop("checked",!$(e).is(':checked'));
				alert("Data was not updated")
			})	
		}

		var newCardItem = function(e){
			val = $("#new_item").val().trim();

			if (val==""){
				$("#new_item").focus();
			}else{
				saveItem("#new_item");
			}
		}

		//getData

		var getCard = function(list_id,list_index,card){
			var cardList = $('<div class="todo_body">')
			$.each(card, function(i, item){
				cardList.append(
					$("<a class='todo_card' data-list-index='"+list_index+"' data-index='"+i+"'  onclick='showCard(this)'>")
						.append(
							$("<span class='todo_card_title'>").html(item.todo_name)
						).append(
							$("<span class='todo_card_badge'>").html(`<i class='icon-check-box'></i> ${item.todo_finish}/${item.todo_sub}`)
						)
				)
			});
			cardList.append(
				'<div class="todo_card_button"><a href="javascript:;" class="todo_add" data-list="'+list_id+'" onclick="newCard(this)"><i class="fa fa-plus"></i> Add Card</a></div>'
			)

			return cardList;
		}

		function getData(){
			$("#todo_list").html("");
			$.ajax({
				url: base_url,
			}).done(function(resp){
				todo = resp;

				$.each(resp, function(i, item){

					$("#todo_list").append(
						$('<div class="col-lg-4">').append(
							$('<div class="card_todo">').append(
								$('<div class="todo_header">').append('<input type="text" placeholder="Enter List Title" class="todo_name listed" data-id="'+item.todo_id+'" value="'+item.todo_name+'" />')
							).append(
								getCard(item.todo_id,i, item.todo_card)
							).append(
							`<div class="todo_footer">
									<ul class="xtab-button xtab-flex">
										<li><a href="javascript:;" onclick="listRemove(this)"  data-id="${item.todo_id}">Remove</a></li>
									</ul>
								</div>`
							)
						)
					)
				});
				$("#todo_list").append(addButton);
			}).fail(function(xhr,status, err){
				$("#todo_list").append(addButton);

			})
		}

		function getCardItem(){
			$(".card_item").html("");
			$.ajax({
				url: base_url+"/item/"+card_id,
			}).done(function(resp){
				$.each(resp, function(i, item){
					$(".card_item").append(
						$("<li>").append(
							`<input class="checkbox_animated" type="checkbox"  data-id="${item.sub_id}" ${item.sub_status==1?"checked":""} onchange="setChecked(this)">`
						).append(
							`<input class="todo_control todo_card_item" value="${item.sub_name}" type="text" data-id="${item.sub_id}" onfocus="setOld(this)" onfocusout="setItemF(this)" onkeypress="setItem(event,this)"><a class="todo_card_item_button" style="color:#333;display:inline-block" data-id="${item.sub_id}" onclick="removeCardItem(this)"><i class="fa fa-remove"></i></a>`
						)						
					)
				});

				countProgress();
			})
		}

		getData();


	</script>
@endsection