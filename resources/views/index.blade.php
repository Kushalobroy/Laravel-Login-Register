<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Dashboard</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">

                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add Task</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="#addTask">
                                                <div class="">
                                                    <input id="#task" class="form-control" type="text" placeholder="Enter Task">
                                                    <label class="form-label ms-2">Task</label>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add</button>
                                                </div>
                                            </form>

                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="table table-responsive">

                                    <h5 class="text-center fw-bold">Task List</h5>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary float-left" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            Add Task
                                        </button>
                                    </div>


                                    <table class="table table-striped">
                                        <thead>
                                            <th>Task</th>
                                            <th>Status</th>
                                            <th>Change Status</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($tasks as $task)
                                                <tr>
                                                    <td>{{ $task->task }}</td>
                                                    <td>{{ $task->status }}</td>
                                                    @if ($task->status === 'done')
                                                        <td><a href="" type="submit" class="btn btn-warning change-status"
                                                                id="mark-pending" data-new-status="pending"
                                                                data-task-id="{{ $task->id }}">Mark as
                                                                Pending</a></td>
                                                    @else
                                                        <td><a href="" class="btn btn-success change-status"
                                                                id="mark-done" data-new-status="done" data-task-id="{{ $task->id }}">Mark
                                                                as Done</a></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#addTask').on('submit', function(e) {
            e.preventDefault();
            var task = $('#task').val();
            var apiKey = 'helloatg';
            var user_id = {{ Auth::user()->id }};

            $.ajax({
                type: 'POST',
                url: '/api/todo/add',
                data: {
                    task: task,
                    user_id: user_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'API_KEY': apiKey,
                },
                success: function(response) {
                    if (response.status === 1) {
                        
                    } else {
                        console.log('Task not added. API response:', response);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
        $('table').on('click', '.change-status', function() {
            var button = $(this);
            var taskId = button.data('task-id');
            var newStatus = button.data('new-status');
            var apiKey = 'helloatg';

            $.ajax({
                type: 'POST',
                url: '/api/todo/status',
                data: {
                    task_id: taskId,
                    status: newStatus,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'API_KEY': apiKey,

                },
                success: function(response) {
                    if (response.status === 1) {
                        var statusCell = button.closest('tr').find('td:nth-child(3)');
                        statusCell.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(
                            1));
                        if (newStatus === 'done') {
                            button.removeClass('btn-success').addClass('btn-danger');
                            button.text('Mark Pending');
                            button.data('new-status', 'pending');
                        } else {
                            button.removeClass('btn-danger').addClass('btn-success');
                            button.text('Mark Done');
                            button.data('new-status', 'done');
                        }
                    } else {
                        console.log('Status not updated. API response:', response);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script></html>
