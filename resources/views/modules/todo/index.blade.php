@extends('layout')

@section('content')
	<div class="card">
		<div class="card-body p-0">
			<ul class="xtab-button">
				<li><a href="javascript:;" onclick="addProject(this)"><i class="fa fa-plus"></i> Add Project</a></li>
				<li><a href="javascript:;" onclick="getData()"><i class="fa fa-refresh"></i> Refresh</a></li>
			</ul>
		</div>
	</div>
	<section id="todo_list" class="row"></section>

	<div class="modal fade" id="add_project" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Project</h5>
					<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form class="row justify-content-md-center" autocomplete="off">
					<div class="modal-body">
						<div class="form-group row">
							<label class="col-form-label col-sm-4" for=""> Project Name (*)</label>
							<div class="col-sm-8">
								<input class="form-control" id="project_name" name="project_name" required="" />
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-sm-4" for=""> Project Description</label>
							<div class="col-sm-8">
								<textarea class="form-control" id="project_desc" name="project_desc"></textarea>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
						<button class="btn btn-secondary" type="submit" onclick=>Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		var project=[];

		var addProject = function(e){
			$("#project_id").remove();
			$("#add_project").find("form")[0].reset();
			$("#add_project").modal("show").on('shown.bs.modal', function () {
			    $('#project_name').focus();
			});
		}

		var saveProject = function(e){
			var data = $("#add_project").find("form")[0]
		}

		$("#add_project form").submit(function(e){
			e.preventDefault();
			var data = $(this).serializeArray();

			$.ajax({
				url: "api/project/set",
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
					$("#add_project").modal("hide")
					$("#add_project").find("form")[0].reset();
					getData();
				}else{
					alert(resp.message);
				}
			}).fail(function(xhr,status, err){
				error = err;
				alert("Data Not Saved.");
			})
		});

		var updateProject = function(e){
			index = $(e).data("index");

			item = project[index];
			console.log(item.project_name);

			$("#add_project").find("form").append("<input type='hidden' id='project_id' name='project_id' value='"+item.project_id+"'/>")

			$("#project_name").val(item.project_name);
			$("#project_desc").val(item.project_desc);
			$("#add_project").modal("show").on('shown.bs.modal', function () {
			    $('#project_name').focus();
			});
		}

		var deleteProject = function(e){
			id = $(e).data("id");
			if(confirm("Are you sure want delete this Project ?")){
				$.ajax({
					url: "api/project/delete/"+id,
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

		function getData(){
			$("#todo_list").html("");
			$.ajax({
				url: "api/project",
			}).done(function(resp){
				project = resp;

				$.each(resp, function(i, item){
					$("#todo_list").append(
						$("<div>",{"class":"col-lg-3"}).append(
							$("<div>",{"class":"todo_project"})
								.append(
									$("<div>",{"class":"project_body"})
										.append(
											$("<h5>",{"class":"project_title"}).html(item.project_name)
										)
										.append(
											$("<p>",{"class":"project_desc"}).html(item.project_desc)
										)
								)
								.append(
									$("<ul>",{"class":"xtab-button xtab-flex"})
										.append(
											$("<li>").append(
												$("<a>",{"data-id":item.project_id,"href":"todo/"+item.project_id,"title":"TODO LIST"}).html('<i class="fa fa-search color-info"></i>')
											)
										)
										.append(
											$("<li>").append(
												$("<a>",{"data-id":item.project_id,"data-index":i,"onclick":"updateProject(this)","title":"EDIT"}).html('<i class="fa fa-pencil color-edit"></i>')
											)
										)
										.append(
											$("<li>").append(
												$("<a>",{"data-id":item.project_id,"onclick":"deleteProject(this)","title":"DELETE"}).html('<i class="fa fa-trash color-remove"></i>')
											)
										)
								)
						)
					)
				});
			})
		}

		getData();


	</script>
@endsection