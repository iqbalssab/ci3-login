
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

                    <a href="<?= base_url('admin/usermanagement') ?>" class="btn btn-primary">Kembali</a>
                    <div class="card mb-5 col-lg-5 mx-auto bg-warning">
                        <?php foreach($users as $u) : ?>
                        <img src="<?= base_url('assets/img/profile/').$u['image']; ?>" class="card-img-top mx-auto" style="max-width: 20rem;">
                        <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-primary text-light">Name : <?= $u['name']; ?></li>
                            <li class="list-group-item bg-primary text-light">Email : <?= $u['email']; ?></li>
                            <li class="list-group-item bg-primary text-light">Role : <?= $u['role_id'] == 1 ? "Admin": "Member"; ?></li>
                            <li class="list-group-item bg-primary text-light">Status : <?= $u['is_active'] == 1 ? "Active": "Inactive"; ?></li>
                            <li class="list-group-item bg-primary text-light">Join Date : <?= date('l d F Y', $u['date_created']); ?></li>
                        </ul>
                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->