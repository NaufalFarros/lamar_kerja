@extends('layouts.app')


<style>

</style>

@section('content')
    <div class="container">
        <section class="vh-100">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-lg-9 col-xl-7">
                        <div class="card rounded-3">
                            <div class="card-body p-4">

                                <h4 class="text-center my-3 pb-3">To Do List</h4>

                                <form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2">
                                    <div class="col-12">
                                        <div class="form-outline">
                                            <input type="text" id="form1" class="form-control" />
                                            <label class="form-label" for="form1">Enter a task here</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">add</button>
                                    </div>


                                </form>

                                <table class="table mb-4">
                                    <thead>
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Todo item</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        {{-- <tr>
                            <th scope="row" id="no_urut"></th>
                            <td id="note"></td>
                            <td id="status"></td>
                            <td>
                              <button type="submit" class="btn btn-danger">Delete</button>
                              <button type="submit" class="btn btn-success ms-1">Finished</button>
                            </td>
                          </tr> --}}

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            // fetch data from on document ready
            fetch_data();


            // create data on button click
            $('.btn-primary').click(function(e) {
                e.preventDefault();
                var note = $('#form1').val();
                $.ajax({
                    url: '/todolist',
                    type: 'POST',
                    dataType: 'json',

                    data: {
                        _token: '{{ csrf_token() }}',
                        note: note,
                        completed: 0
                    },
                    success: function(data) {
                        // console.log(data);
                        // clear input
                        $('#form1').val('');
                        fetch_data();
                    }
                });
            });



            function fetch_data() {
                $.ajax({
                    url: '/todolist/fetch',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        // tambahkan data pada table
                        var html = '';
                        $.each(data, function(key, value) {
                            var key = key + 1;
                            html += '<tr>';
                            html += '<th scope="row" id="id_note" hidden>' + value.id + '</th>';
                            html += '<th scope="row" >' + key + '</th>';
                            html += '<td id="note">' + value.note + '</td>';
                            if (value.completed == 0) {
                                value.completed = 'Not Finished';
                            } else {
                                value.completed = 'Finished';
                            }
                            html += '<td id="status">' + value.completed + '</td>';
                            html += '<td>';
                            html +=
                                '<button type="submit" class="btn btn-danger delete_data">Delete</button>';
                            html +=
                                '<button type="submit" class="btn btn-success ms-1 finished_data">Finished</button>';
                            html += '</td>';
                            html += '</tr>';
                        });
                        $('tbody').html(html);

                        // add event listener to finished button
                        finish_data();
                        delete_data();
                    }
                });
            }
          
          
          
          function finish_data(){
            $('.finished_data').click(function(e) {
                e.preventDefault();
                var id = $(this).closest('tr').find('#id_note').text();
                $.ajax({
                    url: '/todolist/'+id,
                    type: 'PUT',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        completed: 1
                    },

                    success: function(data) {
                        // console.log(data);
                        fetch_data();
                    }
                });
            });
          }

          function delete_data(){
            $('.delete_data').click(function(e) {
                e.preventDefault();
                var id = $(this).closest('tr').find('#id_note').text();
                $.ajax({
                    url: '/todolist/'+id,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                    },

                    success: function(data) {
                        // console.log(data);
                        fetch_data();
                    }
                });
            });
          }
           
        });
    </script>
@endsection
