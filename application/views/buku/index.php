<div class="container">
	<div class="row my-4">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Data Buku</h2>
			</div>
			<div class="pull-right">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah-buku">Tambah Buku</button>
			</div>
		</div>
	</div>
	<div class="row my-4">
		<div class="col-12">
			<div class="card">
				<div class="card-header bg-primary text-white">Data Buku</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover" id="table-buku">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Judul</th>
									<th scope="col">Penerbit</th>
									<th scope="col">Penulis</th>
									<th scope="col">Tahun</th>
									<th scope="col">Jumlah</th>
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

<!-- Create buku Modal -->
<div class="modal" tabindex="-1" id="tambah-buku">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Buku</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form data-toggle="validator" action="buku/store" method="POST" id="form-tambah-buku">
					<div class="form-group">
						<label class="control-label" for="judul">Judul</label>
						<input type="text" name="judul" class="form-control" required placeholder="Masukkan judul" />
						<small class="text-danger" id="judul_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="penerbit">Penerbit</label>
						<input type="text" name="penerbit" class="form-control" required placeholder="Masukkan penerbit" />
						<small class="text-danger" id="penerbit_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="penulis">Penulis</label>
						<input type="text" name="penulis" class="form-control" required placeholder="Masukkan penulis" />
						<small class="text-danger" id="penulis_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="tahun">Tahun</label>
						<input type="number" name="tahun" class="form-control" required placeholder="Masukkan tahun" />
						<small class="text-danger" id="tahun_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="jumlah">Jumlah</label>
						<input type="number" name="jumlah" class="form-control" required placeholder="Masukkan jumlah" />
						<small class="text-danger" id="jumlah_error"></small>
					</div>
					<div class="form-group">
						<button type="submit" class="btn crud-submit btn-success">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Edit buku Modal -->
<div class="modal" tabindex="-1" id="edit-buku">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit buku</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form data-toggle="validator" action="" method="PUT" id="form-edit-buku">
					<div class="form-group">
						<label class="control-label" for="judul">Judul</label>
						<input type="text" name="edit_judul" class="form-control" required placeholder="Masukkan judul" />
						<small class="text-danger" id="edit_judul_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="penerbit">Penerbit</label>
						<input type="text" name="edit_penerbit" class="form-control" required placeholder="Masukkan penerbit" />
						<small class="text-danger" id="edit_penerbit_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="penulis">Penulis</label>
						<input type="text" name="edit_penulis" class="form-control" required placeholder="Masukkan penulis" />
						<small class="text-danger" id="edit_penulis_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="tahun">Tahun</label>
						<input type="number" name="edit_tahun" class="form-control" required placeholder="Masukkan tahun" />
						<small class="text-danger" id="edit_tahun_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="jumlah">Jumlah</label>
						<input type="number" name="edit_jumlah" class="form-control" required placeholder="Masukkan jumlah" />
						<small class="text-danger" id="edit_jumlah_error"></small>
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
	const baseUrlApi = '<?= base_url() ?>buku';
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
					rows = rows + '<td>' + value.judul + '</td>';
					rows = rows + '<td>' + value.penerbit + '</td>';
					rows = rows + '<td>' + value.penulis + '</td>';
					rows = rows + '<td>' + value.tahun + '</td>';
					rows = rows + '<td>' + value.jumlah + '</td>';
					rows = rows + '<td data-id="' + value.id + '">';
					rows = rows + '<button data-toggle="modal" data-target="#edit-buku" class="btn btn-primary edit-buku">Edit</button> ';
					rows = rows + '<button class="btn btn-danger remove-buku">Delete</button>';
					rows = rows + '</td>';
					rows = rows + '</tr>';
				});
			} else {
				rows = rows + '<tr>';
				rows = rows + '<td  colspan="7" class="text-center">Data kosong</td>';
				rows = rows + '</tr>';
			}
			$("tbody").html(rows);
		});
	}

	/* Create new User */
	$(".crud-submit").click(function(e) {
		e.preventDefault();
		var form_action = $("#tambah-buku").find("form").attr("action");
		var judul = $("#tambah-buku").find("input[name='judul']").val();
		var penerbit = $("#tambah-buku").find("input[name='penerbit']").val();
		var penulis = $("#tambah-buku").find("input[name='penulis']").val();
		var tahun = $("#tambah-buku").find("input[name='tahun']").val();
		var jumlah = $("#tambah-buku").find("input[name='jumlah']").val();
		$.ajax({
			url: form_action,
			dataType: 'json',
			type: "POST",
			data: {
				judul: judul,
				penerbit: penerbit,
				penulis: penulis,
				jumlah: jumlah,
				tahun: tahun,
			},
			dataType: "json",
			success: function(data) {
				if (data.status == false) {
					if (data.errors.penerbit_error != '') {
						$('#penerbit_error').html(data.errors.penerbit_error);
					} else {
						$('#penerbit_error').html('');
					}
					if (data.errors.judul_error != '') {
						$('#judul_error').html(data.errors.judul_error);
					} else {
						$('#judul_error').html('');
					}
					if (data.errors.penulis_error != '') {
						$('#penulis_error').html(data.errors.penulis_error);
					} else {
						$('#penulis_error').html('');
					}
					if (data.errors.tahun_error != '') {
						$('#tahun_error').html(data.errors.tahun_error);
					} else {
						$('#tahun_error').html('');
					}
					if (data.errors.jumlah_error != '') {
						$('#jumlah_error').html(data.errors.jumlah_error);
					} else {
						$('#jumlah_error').html('');
					}
				}
				if (data.status == true) {
					$('#penerbit_error').html('');
					$('#judul_error').html('');
					$('#penulis_error').html('');
					$('#tahun_error').html('');
					$('#jumlah_error').html('');
					$('#form-tambah-buku')[0].reset();

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

	$("body").on("click", ".edit-buku", function() {
		var id = $(this).parent("td").data('id');
		var jumlah = $(this).parent("td").prev("td").text();
		var penulis = $(this).parent("td").prev("td").prev("td").prev("td").text();
		var penerbit = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").text();
		var judul = $(this).parent("td").prev("td").prev("td").prev("td").text();
		var tahun = $(this).parent("td").prev("td").prev("td").text();
		var judul = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").prev("td").text();
		$("#edit-buku").find("input[name='edit_penerbit']").val(penerbit);
		$("#edit-buku").find("input[name='edit_judul']").val(judul);
		$("#edit-buku").find("input[name='edit_penulis']").val(penulis);
		$("#edit-buku").find("input[name='edit_tahun']").val(tahun);
		$("#edit-buku").find("input[name='edit_jumlah']").val(jumlah);
		$("#edit-buku").find("form").attr("action", baseUrlApi + '/update/' + id);
	});


	/* Updated new User */
	$(".crud-submit-edit").click(function(e) {
		e.preventDefault();
		var form_action = $("#edit-buku").find("form").attr("action");
		var judul = $("#edit-buku").find("input[name='edit_judul']").val();
		var penerbit = $("#edit-buku").find("input[name='edit_penerbit']").val();
		var penulis = $("#edit-buku").find("input[name='edit_penulis']").val();
		var tahun = $("#edit-buku").find("input[name='edit_tahun']").val();
		var jumlah = $("#edit-buku").find("input[name='edit_jumlah']").val();
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: form_action,
			data: {
				judul: judul,
				penerbit: penerbit,
				penulis: penulis,
				jumlah: jumlah,
				tahun: tahun,
			},
			success: function(data) {
				if (data.status == false) {
					if (data.errors.penerbit_error != '') {
						$('#penerbit_error').html(data.errors.penerbit_error);
					} else {
						$('#penerbit_error').html('');
					}
					if (data.errors.judul_error != '') {
						$('#judul_error').html(data.errors.judul_error);
					} else {
						$('#judul_error').html('');
					}
					if (data.errors.penulis_error != '') {
						$('#penulis_error').html(data.errors.penulis_error);
					} else {
						$('#penulis_error').html('');
					}
					if (data.errors.tahun_error != '') {
						$('#tahun_error').html(data.errors.tahun_error);
					} else {
						$('#tahun_error').html('');
					}
					if (data.errors.jumlah_error != '') {
						$('#jumlah_error').html(data.errors.jumlah_error);
					} else {
						$('#jumlah_error').html('');
					}
				}
				if (data.status == true) {
					$('#penerbit_error').html('');
					$('#judul_error').html('');
					$('#penulis_error').html('');
					$('#tahun_error').html('');
					$('#jumlah_error').html('');
					$('#form-tambah-buku')[0].reset();


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
	$("body").on("click", ".remove-buku", function() {
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
