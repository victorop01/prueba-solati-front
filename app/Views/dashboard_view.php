<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<!-- Encabezado -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><img src="http://pruebasolati.kesug.com/prueba-tecnica/app/Img/solati.png" alt="Logo" style="width: 50px;"></a>
    <div class="ml-auto">
        <span>Bienvenido, <?= session()->get('nombre_completo'); ?></span>
        <a href="<?= site_url('/logout'); ?>" class="btn btn-danger ml-3">Cerrar sesión</a>
    </div>
</nav>

<div class="container mt-5">
    <h2>Tareas</h2>
    <!-- Botón para crear una nueva tarea -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createTaskModal">Crear Tarea</button>

    <!-- Tabla de tareas -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="taskTable">
            <!-- se llenan las filas de tareas -->
        </tbody>
    </table>
</div>

<!-- Modal para crear una nueva tarea -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTaskModalLabel">Crear Tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createTaskForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="taskTitle">Título</label>
                        <input type="text" class="form-control" id="taskTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="taskDescription">Descripción</label>
                        <textarea class="form-control" id="taskDescription" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="taskStatus">Estado</label>
                        <select class="form-control" id="taskStatus" required>
                            <option value="pendiente">Pendiente</option>
                            <option value="completada">Completada</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Crear Tarea</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para editar tarea -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel">Editar Tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editTaskForm">
                <input type="hidden" id="idtask" name="idtask">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editTaskTitle">Título</label>
                        <input type="text" class="form-control" id="editTaskTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="editTaskDescription">Descripción</label>
                        <textarea class="form-control" id="editTaskDescription" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editTaskStatus">Estado</label>
                        <select class="form-control" id="editTaskStatus" required>
                            <option value="pendiente">Pendiente</option>
                            <option value="completada">Completada</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Función para cargar las tareas
    $(document).ready(function() {
        loadTasks();

        // Función para obtener tareas
        function loadTasks() {
            $.ajax({
                url: 'https://prueba-solati.onrender.com/api/tasks/',  // URL de la API para obtener tareas
                type: 'GET',
                headers: {
                    'Authorization': '<?= session()->get('token'); ?>',  // Usar el token de la sesión
                },
                success: function(response) {
                    // Verifica si 'data' contiene las tareas
                    if (response && response.data) {
                        var tasks = response.data;
                        var taskTable = $('#taskTable');
                        taskTable.empty();

                        // Asegúrate de que tasks no esté vacío
                        if (tasks.length > 0) {
                            tasks.forEach(function(task) {
                                taskTable.append(`
                                    <tr>
                                        <td>${task.id}</td>
                                        <td>${task.title}</td>
                                        <td>${task.description}</td>
                                        <td>${task.status}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" onclick="editTask(${task.id})">Editar</button>
                                            <button class="btn btn-danger btn-sm ml-2" onclick="deleteTask(${task.id})">Eliminar</button>
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            taskTable.append('<tr><td colspan="5">No hay tareas disponibles</td></tr>');
                        }
                    } else {
                        console.log('Respuesta no válida de la API');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener tareas:', error);
                    alert('Hubo un problema al obtener las tareas.');
                }
            });
        }

        // Función para editar una tarea
        window.editTask = function(id) {
            $.ajax({
                url: 'https://prueba-solati.onrender.com/api/tasks/' + id,
                type: 'GET',
                headers: {
                    'Authorization': '<?= session()->get('token'); ?>',
                },
                success: function(response) {
                    var task = response.data[0];
                    $('#editTaskTitle').val(task.title);
                    $('#editTaskDescription').val(task.description);
                    $('#editTaskStatus').val(task.status);
                    $('#idtask').val(id);
                    $('#editTaskModal').modal('show');
                }
            });
        };

        // Guardar cambios de tarea
        $('#editTaskForm').on('submit', function(event) {
            event.preventDefault();

            var id = $('#idtask').val();
            var title = $('#editTaskTitle').val();
            var description = $('#editTaskDescription').val();
            var status = $('#editTaskStatus').val();

            $.ajax({
                url: 'https://prueba-solati.onrender.com/api/tasks/update_task/' + id,
                type: 'PUT',
                headers: {
                    'Authorization': '<?= session()->get('token'); ?>',
                },
                data: {
                    title: title,
                    description: description,
                    status: status,
                },
                success: function(response) {
                    $('#editTaskModal').modal('hide');
                    loadTasks();
                }
            });
        });

        // Crear nueva tarea
        $('#createTaskForm').on('submit', function(event) {
            event.preventDefault();

            var title = $('#taskTitle').val();
            var description = $('#taskDescription').val();
            var status = $('#taskStatus').val();

            $.ajax({
                url: 'https://prueba-solati.onrender.com/api/tasks/create_task',
                type: 'POST',
                headers: {
                    'Authorization': '<?= session()->get('token'); ?>',
                },
                data: {
                    title: title,
                    description: description,
                    status: status,
                },
                success: function(response) {
                    $('#createTaskModal').modal('hide');
                    loadTasks();
                }
            });
        });

        // Función para eliminar una tarea
        window.deleteTask = function(id) {
            if (confirm("¿Estás seguro de que deseas eliminar esta tarea?")) {
                $.ajax({
                    url: 'https://prueba-solati.onrender.com/api/tasks/' + id,
                    type: 'DELETE',
                    headers: {
                        'Authorization': '<?= session()->get('token'); ?>',
                    },
                    success: function(response) {
                        alert('Tarea eliminada exitosamente.');
                        loadTasks(); 
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al eliminar tarea:', error);
                        alert('Hubo un problema al eliminar la tarea.');
                    }
                });
            }
        };
    });
</script>
</body>
</html>
