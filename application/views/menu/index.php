
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

                                <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Add New Menu</a>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Menu</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach($menu as $m) : ?>
                                    <tr>
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $m['menu']; ?></td>
                                        <td>

                                        <a href="" class="badge badge-success" data-toggle="modal" data-target="#editMenuModal<?= $m['id'];?>">Edit</a>
                                        <a href="<?= base_url('menu/delete/').$m['id']; ?>" class="badge badge-danger" onclick="return confirm('delete menu?');">Delete</a>
                                        
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
<div class="modal fade" id="newMenuModal" tabindex="-1" aria-labelledby="newMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newMenuModalLabel">Add New Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('menu') ?>" method="post">
      <div class="modal-body">
        <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu Name">
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
<?php foreach($menu as $m) : ?>
<div class="modal fade" id="editMenuModal<?= $m['id'];?>" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editMenuModalLabel">Edit Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('menu/edit/').$m['id']; ?>" method="post">
      <div class="modal-body">
      <input type="hidden" name="id" value="<?= $m['id']?>">
        <input type="text" class="form-control" id="menu" name="menu" value="<?= $m['menu'] ?>">
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
  