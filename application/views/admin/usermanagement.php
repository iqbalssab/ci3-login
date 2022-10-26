
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

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
                                        <a href="" class="badge badge-success" data-toggle="modal" data-target="#editRoleModal<?= $u['id'];?>">Edit</a>
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

            <!-- Detail Modal -->
<?php foreach($users as $u) : ?>
<div class="modal fade" id="editRoleModal<?= $u['id'];?>" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRoleModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('admin/edituser/').$u['id']; ?>" method="post">
      <div class="modal-body">
      <input type="hidden" name="id" value="<?= $u['id']?>">
        <input type="text" class="form-control" id="role" name="role" value="<?= $u['name'] ?>">
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
           