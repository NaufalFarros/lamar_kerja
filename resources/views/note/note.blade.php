@extends('layouts.app')

@section('content')
    <div class="container">

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tambah Note
        </button>

        <table id="notes-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User Name</th>
                    <th>Description</th>
                    <th>Tanggal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notes as $note)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $note->user->name }}</td>
                        <td>{{ $note->note }}</td>
                        <td>{{ $note->created_at->format('d F Y H:i:s') }}</td>
                        <td>
                            <button type="button" data-id="{{ $note->id }}" class="btn btn-primary edit-btn">Edit</button>
                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>



        <!-- Modal Tambah -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('notes.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="note" class="form-label">Note Description</label>
                                <input type="text" name="Note_Description" class="form-control" id="note"
                                    aria-describedby="noteHelp">
                                <div id="noteHelp" class="form-text">catat note anda</div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Edit -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Edit Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            @csrf
                            <div class="mb-3">
                              <input type="text" id="id_note_edit" hidden>
                                <label for="note" class="form-label">Note Description</label>
                                <input type="text" id="edit_note_des" name="Note_Description" class="form-control"
                                    id="note" aria-describedby="noteHelp">
                                <div id="noteHelp" class="form-text">catat note anda</div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>




    </div>


    <script>
        $(document).ready(function() {
            var table = $('#notes-table').DataTable();

            // Menangani klik tombol edit
            $('#notes-table tbody').on('click', '.edit-btn', function(e) {
                e.preventDefault();
                // Mendapatkan baris yang terkait dengan tombol edit
                var row = $(this).closest('tr');
                // Mendapatkan nilai-nilai dari kolom-kolom di dalam baris
                var data = table.row(row).data();
                var noteId = $(this).data('id');
                console.log(noteId);
                // Menampilkan modal edit data dengan nilai-nilai dari kolom-kolom
                $('#exampleModal2').modal('show');
                $('#exampleModal2 #edit_note_des').val(data[2]);
                $('#id_note_edit').val(noteId);

            });
            // fucntion untuk mengupdate data
            $('#exampleModal2').on('submit', function(e) {
                e.preventDefault();
                var noteId = $('#id_note_edit').val();
                var note = $('#edit_note_des').val();
                console.log(noteId);
                console.log(note);
                $.ajax({
                    url: '/note/' + noteId,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        note: note
                    },
                    success: function(response) {
                        console.log(response);
                        $('#exampleModal2').modal('hide');
                        // sweet alert
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Data berhasil diupdate',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            location.reload();
                        });
                    }
                });
            });


        });
    </script>
@endsection
