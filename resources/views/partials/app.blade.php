<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
    @include('partials.head')
</head>

<body>
    <div class="layout-wrapper layout-content-navbar bg-white">
        <div class="layout-container">
            @include('partials.sidebar')
            <div class="layout-page" style="background-color: #f5f5f9">
                @include('partials.navbar')
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteStaff(id) {
            var form = document.getElementById('deleteStaff');
            form.action = '/staff/' + id
            $('#deleteModal').modal('show')
        }

        function deleteStudent(id) {
            var form = document.getElementById('deleteStudent');
            form.action = '/student/' + id
            $('#deleteModal').modal('show')
        }

        function deleteUser(id) {
            var form = document.getElementById('deleteUser');
            form.action = '/user/' + id
            $('#deleteModal').modal('show')
        }
    </script>
    @include('partials.script')
</body>

</html>
