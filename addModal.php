<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<div id="addBugReportModal" class="modal fade">
	<div class="modal-dialog contact-modal">
		<div class="modal-content">
			<div class="modal-header">				
				<h4 class="modal-title">Submit bug Report</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <select name="report_type" class="form-control" required>
                            <option value="video player">Video Player</option>
                            <option value="audio">Audio</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" name="message" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="link">Link</label>
                        <input class="form-control" name="link" id="link" required></input>
                    </div>
                    <input type="submit" class="btn btn-primary" name="add" value="Add">
                    <input type="button" class="btn btn-link" data-dismiss="modal" value="Cancel">
                </form>
			</div>
		</div>
	</div>
</div>