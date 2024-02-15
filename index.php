<?php require_once __DIR__ . '/header.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/resources/css/styles.css">
    <title>Bug Reporter App</title>
    </head>
    <body>
        <div class="container">
            <div class="table-wrapper">
                <div class="table-title mt-3">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Bug Reports</b></h2>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-end">
                            <a href="#addBugReportModal" class="btn btn-primary mb-auto mt-auto" data-toggle="modal"><i class="bi bi-plus-circle-fill h6 mx-auto px-1"></i> <span>Add Report</span></a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col" style="width: 120px;">Report Type</th>
                        <th scope="col">Email</th>
                        <th scope="col" style="width: 240px;">Message</th>
                        <th scope="col">Link</th>
                        <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($bugReports)): ?>
                    <?php /** @var \App\Entities\BugReport $bugReports */?>
                        <?php foreach($bugReports as $report): ?>
                            <tr>
                            <td><?php echo $report->getReportType() ?></td>
                            <td><?php echo $report->getEmail() ?></td>
                            <td><?php echo $report->getMessage() ?></td>
                            <td><?php echo $report->getLink() ?></td>
                            <td class="d-inline-flex">
                                <a href="#updateReport-<?php echo $report->getId(); ?>" data-toggle="modal"><i class="bi bi-pencil-fill h5 text-warning align-items-center mx-auto p-1"></i></a>
                                <a href="#deleteReport-<?php echo $report->getId(); ?>" data-toggle="modal"><i class="bi bi-trash3-fill h5 text-danger align-items-center mx-auto p-1"></i></a>

                                <div id="updateReport-<?php echo $report->getId(); ?>" class="modal fade">
                                    <div class="modal-dialog contact-modal">
                                        <div class="modal-content">
                                            <div class="modal-header">				
                                                <h4 class="modal-title">Edit Bug Report</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post">
                                                    <div class="form-group">
                                                        <select name="report_type" class="form-control" required>
                                                            <option value="<?php echo $report->getReportType() ?>"><?php echo $report->getReportType() ?></option>
                                                            <option value="video player">video player</option>
                                                            <option value="audio">audio</option>
                                                            <option value="other">other</option>

                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" name="email" class="form-control" value="<?php echo $report->getEmail() ?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="message">Message</label>
                                                        <textarea class="form-control" name="message" required><?php echo $report->getMessage() ?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="link">Link</label>
                                                        <input class="form-control" name="link" id="link" value="<?php echo $report->getLink() ?>" required></input>
                                                    </div>
                                                    <input type="hidden" name="reportId" value="<?php echo $report->getId(); ?>">
                                                    <input type="submit" class="btn btn-primary" name="update" value="Save">
                                                    <input type="button" class="btn btn-link" data-dismiss="modal" value="Cancel">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>  

                                <div id="deleteReport-<?php echo $report->getId(); ?>" class="modal fade">
                                    <div class="modal-dialog modal-confirm">
                                        <form method="post">
                                            <div class="modal-content">
                                                <div class="modal-header">			
                                                    <h4 class="modal-title">Are you sure?</h4>	
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Do you really want to delete this record? This process cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="reportId" value="<?php echo $report->getId(); ?>">
                                                    <input type="button" class="btn btn-info" data-dismiss="modal" value="Cancel">
                                                    <input type="submit" class="btn btn-danger" name="delete" value="Delete">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>     
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php include_once "addModal.php"; ?>

        <!-- Scripts -->
        <script src="resources/js/script.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>