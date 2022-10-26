
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
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach($users as $u) : ?>
                                    <tr>
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $u['name']; ?></td>
                                        <td><?= $u['email']; ?></td>
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
      <form action="<?= base_url('admin/editusermanagement/').$u['id']; ?>" method="post">
      <div class="modal-body">
      <input type="hidden" name="id" value="<?= $u['id']?>">
        <div class="form-group">
            <input type="text" class="form-control" id="user_name" name="user_name" value="<?= $u['name'] ?>">
        </div>
        <div class="form-group">
        <input type="text" class="form-control" id="role_id" name="role_id" value="<?= $u['role_id'] ?>">
        </div>
        <div class="form-group">
        <input type="text" class="form-control" id="is_active" name="is_active" value="<?= $u['is_active'] ?>">
        </div>
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
           