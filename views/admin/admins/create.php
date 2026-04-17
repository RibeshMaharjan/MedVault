<div class="container-fluid bg-white">
    <div class="row px-3 p-4"><div class="col"><h1 class="fw-normal mb-3">Add Admin</h1></div></div>
    <div class="row px-3 pb-4">
        <form action="/admin/admins" method="POST" class="form" autocomplete="off">
            <div class="mb-3"><label class="form-label">Name</label><input class="form-control" type="text" name="name" required></div>
            <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" required></div>
            <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
            <div class="mb-3"><label class="form-label">Gender</label>
                <select class="form-select" name="gender"><option value="Male">Male</option><option value="Female">Female</option><option value="Other">Other</option></select>
            </div>
            <div class="mb-3"><label class="form-label">Phone</label><input class="form-control" type="text" name="phone" required></div>
            <div class="mb-3"><label class="form-label">Date of Birth</label><input class="form-control" type="date" name="birth" required></div>
            <div class="mb-3"><label class="form-label">Address</label><input class="form-control" type="text" name="address" required></div>
            <input type="submit" value="Add Admin" class="btn btn-danger" name="add-admin">
        </form>
    </div>
</div>
