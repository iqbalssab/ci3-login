
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

                    <?= $this->session->flashdata('message') ?>

                    <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach($users as $u) : ?>
                                    <tr>
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $u['name']; ?></td>
                                        <?php $role = $u['role_id']; ?>
                                        <?php if($role == 1) : ?>
                                        <td>Admin</td>
                                        <?php elseif($role == 2) : ?>
                                        <td>Member</td>
                                        <?php elseif($role == 3) : ?>
                                        <td>Supervisor</td>
                                        <?php endif ?>
                                        <td>

                                        <a href="<?= base_url('admin/userdetail/') . $u['id']; ?>" class="badge badge-primary">Detail</a>
                                        <a href="" class="badge badge-success" data-toggle="modal" data-target="#editUserModal<?= $u['id'];?>">Edit</a>
                                        <a href="<?= base_url('admin/deleteUser/').$u['id']; ?>" class="badge badge-danger" onclick="return confirm('delete role?');">Delete</a>
                                        
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                                </table>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Edit Modal -->
<?php foreach($users as $u) : ?>
<div class="modal fade" id="editUserModal<?= $u['id'];?>" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('admin/editUserManagement/').$u['id']; ?>" method="post">
      <div class="modal-body">
      <input type="hidden" name="id" value="<?= $u['id']?>">
        <div class="form-group">
            <input type="text" class="form-control" id="name" name="name" value="<?= $u['name'] ?>">
        </div>
        <!-- RoleID -->
        <fieldset class="mb-1 p-2" style="border: 0.5px solid black;">
            <legend class="px-2" style="font-size: 1.2rem;">Role :</legend>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role_id" id="role_id" value="1" <?= $u['role_id'] == 1 ? "checked" : ""; ?>>
                <label class="form-check-label" for="role_id">Admin</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role_id" id="role_id" value="2" <?= $u['role_id'] == 2 ? "checked" : ""; ?>>
                <label class="form-check-label" for="role_id">User</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role_id" id="role_id" value="3" <?= $u['role_id'] == 3 ? "checked" : ""; ?>>
                <label class="form-check-label" for="role_id">Supervisor</label>
            </div>
        <!-- Status -->
        </fieldset>
        <fieldset class="mb-1 p-2" style="border: 0.5px solid black;">
            <legend class="px-2" style="font-size: 1.2rem;">Status :</legend>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1" <?= $u['is_active'] == 1 ? "checked" : ""; ?>>
                <label class="form-check-label" for="is_active">Active</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_active" id="is_active" value="0" <?= $u['is_active'] == 0 ? "checked" : ""; ?>>
                <label class="form-check-label" for="is_active">Non-Active</label>
            </div>
        </fieldset>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="return confirm('Yakin Ubah?');">Save</button>
      </div>
      </form>
      </div>
      </div>
      </div>
<?php endforeach;?>
           