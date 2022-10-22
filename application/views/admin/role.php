
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

                        <div class="row">
                            <div class="col-lg-6">
                            <?= form_error('menu', '
                                <div class="alert alert-danger" role="alert">','</div>') 
                            ?>

                            <?= $this->session->flashdata('message') ?>

                                <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">Add New Role</a>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach($role as $r) : ?>
                                    <tr>
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $r['role']; ?></td>
                                        <td>

                                        <a href="<?= base_url('admin/roleaccess/') . $r['id']; ?>" class="badge badge-primary">Access</a>
                                        <a href="" class="badge badge-success" data-toggle="modal" data-target="#editRoleModal<?= $r['id'];?>">Edit</a>
                                        <a href="<?= base_url('admin/deleteRole/').$r['id']; ?>" class="badge badge-danger" onclick="return confirm('delete role?');">Delete</a>
                                        
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                                </table>
                            </div>
                        </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<!-- Modal -->
  

<!-- Tambah Modal -->
<div class="modal fade" id="newRoleModal" tabindex="-1" aria-labelledby="newRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newRoleModalLabel">Add New Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('admin/role') ?>" method="post">
      <div class="modal-body">
        <input type="text" class="form-control" id="role" name="role" placeholder="Role Name">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<?php foreach($role as $r) : ?>
<div class="modal fade" id="editRoleModal<?= $r['id'];?>" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('admin/editrole/').$r['id']; ?>" method="post">
      <div class="modal-body">
      <input type="hidden" name="id" value="<?= $r['id']?>">
        <input type="text" class="form-control" id="role" name="role" value="<?= $r['role'] ?>">
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
  