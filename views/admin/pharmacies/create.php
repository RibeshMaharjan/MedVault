<div class="container-fluid bg-white">
    <div class="row px-3 p-4"><div class="col"><h1 class="fw-normal mb-3">Add Pharmacy</h1></div></div>
    <div class="row px-3 pb-4">
        <form action="/admin/pharmacies" method="POST" class="form" autocomplete="off">
            <div class="mb-3"><label class="form-label">PAN Number</label><input class="form-control" type="text" name="pan" required></div>
            <div class="mb-3"><label class="form-label">Pharmacy Name</label><input class="form-control" type="text" name="name" required></div>
            <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" required></div>
            <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
            <div class="mb-3"><label class="form-label">Phone</label><input class="form-control" type="text" name="phone" required></div>
            <div class="mb-3"><label class="form-label">Address</label><input class="form-control" type="text" name="address" required></div>
            <input type="submit" value="Add Pharmacy" class="btn btn-danger" name="add-user">
        </form>
    </div>
</div>
