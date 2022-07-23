<div class="container">
	<div class="row my-4">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Data Mahasiswa</h2>
			</div>
			<div class="pull-right">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah-mhs">Tambah Mahasiswa</button>
			</div>
		</div>
	</div>
	<div class="row my-4">
		<div class="col-12">
			<div class="card">
				<div class="card-header bg-primary text-white">Data Mahasiswa</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover" id="table-mhs">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nama</th>
									<th scope="col">Email</th>
									<th scope="col">Jurusan</th>
									<th scope="col">Aksi</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<ul id="pagination" class="pagination-sm"></ul>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Create mahasiswa Modal -->
<div class="modal" tabindex="-1" id="tambah-mhs">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah mahasiswa</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form data-toggle="validator" action="mahasiswa/store" method="POST" id="form-tambah-mhs">
					<div class="form-group">
						<label class="control-label" for="nama">Nama</label>
						<input type="text" name="nama" class="form-control" required placeholder="Masukkan nama" />
						<small class="text-danger" id="nama_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="email">Email</label>
						<input type="email" name="email" class="form-control" required placeholder="Masukkan email" />
						<small class="text-danger" id="email_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="jurusan">Jurusan</label>
						<input type="text" name="jurusan" class="form-control" required placeholder="Masukkan jurusan" />
						<small class="text-danger" id="jurusan_error"></small>
					</div>
					<div class="form-group">
						<button type="submit" class="btn crud-submit btn-success">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Edit mahasiswa Modal -->
<div class="modal" tabindex="-1" id="edit-mhs">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit mahasiswa</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form data-toggle="validator" action="" method="PUT" id="form-edit-mhs">
					<div class="form-group">
						<label class="control-label" for="edit_nama">Nama</label>
						<input type="text" name="edit_nama" class="form-control" required placeholder="Masukkan nama" />
						<small class="text-danger" id="edit_nama_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="edit_email">Email</label>
						<input type="email" name="edit_email" class="form-control" required placeholder="Masukkan email" />
						<small class="text-danger" id="edit_email_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="edit_jurusan">Jurusan</label>
						<input type="text" name="edit_jurusan" class="form-control" required placeholder="Masukkan jurusan" />
						<small class="text-danger" id="edit_jurusan_error"></small>
					</div>
					<div class="form-group">
						<button type="submit" class="btn crud-submit-edit btn-success">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	const baseUrlApi = '<?= base_url() ?>mahasiswa';
	var page = 1;
	var current_page = 1;
	var total_page = 0;
	var is_ajax_fire = 0;

	manageData();

	/* manage data list */
	function manageData(search = '') {
		$.ajax({
			type: "GET",
			dataType: 'json',
			url: baseUrlApi + '/all',
			data: {
				page: page,
			}
		}).done(function(data) {
			total_page = data.total % 5;
			current_page = page;
			var rows = '';
			if (data.data.length > 0) {
				let i = 1;
				$.each(data.data, function(key, value) {
					rows = rows + '<tr>';
					rows = rows + '<td>' + (i++) + '</td>';
					rows = rows + '<td>' + value.nama + '</td>';
					rows = rows + '<td>' + value.email + '</td>';
					rows = rows + '<td>' + value.jurusan + '</td>';
					rows = rows + '<td data-id="' + value.id + '">';
					rows = rows + '<button data-toggle="modal" data-target="#edit-mhs" class="btn btn-primary edit-mhs">Edit</button> ';
					rows = rows + '<button class="btn btn-danger remove-mhs">Delete</button>';
					rows = rows + '</td>';
					rows = rows + '</tr>';
				});
			} else {
				rows = rows + '<tr>';
				rows = rows + '<td  colspan="6" class="text-center">Data kosong</td>';
				rows = rows + '</tr>';
			}
			$("tbody").html(rows);
		});
	}

	/* Create new User */
	$(".crud-submit").click(function(e) {
		e.preventDefault();
		var form_action = $("#tambah-mhs").find("form").attr("action");
		var email = $("#tambah-mhs").find("input[name='email']").val();
		var nama = $("#tambah-mhs").find("input[name='nama']").val();
		var jurusan = $("#tambah-mhs").find("input[name='jurusan']").val();
		$.ajax({
			url: form_action,
			dataType: 'json',
			type: "POST",
			data: {
				email: email,
				nama: nama,
				jurusan: jurusan
			},
			dataType: "json",
			success: function(data) {
				if (data.status == false) {
					if (data.errors.nama_error != '') {
						$('#nama_error').html(data.errors.nama_error);
					} else {
						$('#nama_error').html('');
					}
					if (data.errors.email_error != '') {
						$('#email_error').html(data.errors.email_error);
					} else {
						$('#email_error').html('');
					}
					if (data.errors.jurusan_error != '') {
						$('#jurusan_error').html(data.errors.jurusan_error);
					} else {
						$('#jurusan_error').html('');
					}
				}
				if (data.status == true) {
					$('#nama_error').html('');
					$('#email_error').html('');
					$('#jurusan_error').html('');
					$('#form-tambah-mhs')[0].reset();

					manageData();
					$(".modal").modal('hide');
					toastr.success('Data berhasil ditambahkan.', 'Success Alert', {
						timeOut: 5000
					});
				}
			}
		})
	});

	$('#search').keyup(function() {
		var search = $(this).val();
		if (search != '') {
			manageData(search);
		} else {
			manageData();
		}
	});

	$("body").on("click", ".edit-mhs", function() {
		var id = $(this).parent("td").data('id');
		var jurusan = $(this).parent("td").prev("td").text();
		var email = $(this).parent("td").prev("td").prev("td").prev("td").text();
		var nama = $(this).parent("td").prev("td").prev("td").text();
		$("#edit-mhs").find("input[name='edit_nama']").val(nama);
		$("#edit-mhs").find("input[name='edit_email']").val(email);
		$("#edit-mhs").find("input[name='edit_jurusan']").val(jurusan);
		$("#edit-mhs").find("form").attr("action", baseUrlApi + '/update/' + id);
	});


	/* Updated new User */
	$(".crud-submit-edit").click(function(e) {
		e.preventDefault();
		var form_action = $("#edit-mhs").find("form").attr("action");
		var jurusan = $("#edit-mhs").find("input[name='edit_jurusan']").val();
		var nama = $("#edit-mhs").find("input[name='edit_nama']").val();
		var email = $("#edit-mhs").find("input[name='edit_email']").val();
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: form_action,
			data: {
				email: email,
				nama: nama,
				jurusan: jurusan
			},
			success: function(data) {
				if (data.status == false) {
					if (data.errors.nama_error != '') {
						$('#edit_nama_error').html(data.errors.nama_error);
					} else {
						$('#edit_nama_error').html('');
					}
					if (data.errors.email_error != '') {
						$('#edit_email_error').html(data.errors.email_error);
					} else {
						$('#edit_email_error').html('');
					}
					if (data.errors.jurusan_error != '') {
						$('#edit_jurusan_error').html(data.errors.jurusan_error);
					} else {
						$('#edit_jurusan_error').html('');
					}
				}
				if (data.status == true) {
					$('#edit_nama_error').html('');
					$('#edit_email_error').html('');
					$('#edit_jurusan_error').html('');
					$('#form-edit-mhs')[0].reset();

					manageData();
					$(".modal").modal('hide');
					toastr.success('Data berhasil diupdate.', 'Success Alert', {
						timeOut: 5000
					});
				}
			}
		})
	});

	/* Remove User */
	$("body").on("click", ".remove-mhs", function() {
		var id = $(this).parent("td").data('id');
		var c_obj = $(this).parents("tr");
		$.ajax({
			dataType: 'json',
			type: 'delete',
			url: baseUrlApi + '/delete/' + id,
		}).done(function(data) {
			c_obj.remove();
			toastr.success('Data berhasil dihapus.', 'Success Alert', {
				timeOut: 5000
			});
			manageData();
		});
	});
</script>
