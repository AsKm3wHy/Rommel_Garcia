<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// DB connection
$mysqli = new mysqli("localhost", "root", "", "rommelgarciaappointments");
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}
$gallery_dir = '../uploads/gallery/';
if (!is_dir($gallery_dir)) {
    mkdir($gallery_dir, 0777, true);
}

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_image'])) {
    $category = $_POST['category'] ?? '';
    $allowed_categories = ["SOLO","DUO","TRIO","QUAD","DELUXE","GROUP","GRADUATE","UNO","DOS","TRES","CUATRO","CINCO","SEIS"];
    if (!in_array($category, $allowed_categories)) $category = '';
    if (!empty($_FILES['image']['name']) && $category) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $filename = uniqid('gallery_', true) . '.' . $ext;
        $target = $gallery_dir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $stmt = $mysqli->prepare("INSERT INTO gallery (filename, category) VALUES (?, ?)");
            $stmt->bind_param('ss', $filename, $category);
            $stmt->execute();
            $stmt->close();
            header('Location: post.php?action=added');
            exit;
        } else {
            $upload_error = 'Failed to upload image.';
        }
    } else {
        $upload_error = 'Image and category are required.';
    }
}

// Handle delete
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'delete' && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    $res = $mysqli->query("SELECT filename FROM gallery WHERE id=$id");
    if ($row = $res->fetch_assoc()) {
        $file = $gallery_dir . $row['filename'];
        if (file_exists($file)) unlink($file);
    }
    $mysqli->query("DELETE FROM gallery WHERE id=$id");
    header('Location: post.php?action=deleted');
    exit;
}

// Handle category edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_category'], $_POST['id'], $_POST['category'])) {
    $id = (int)$_POST['id'];
    $category = $_POST['category'];
    $allowed_categories = ["SOLO","DUO","TRIO","QUAD","DELUXE","GROUP","GRADUATE","UNO","DOS","TRES","CUATRO","CINCO","SEIS"];
    if (in_array($category, $allowed_categories)) {
        $stmt = $mysqli->prepare("UPDATE gallery SET category=? WHERE id=?");
        $stmt->bind_param('si', $category, $id);
        $stmt->execute();
        $stmt->close();
        header('Location: post.php?action=edited');
        exit;
    }
}

// Handle sorting
$sort = $_GET['sort'] ?? 'date_desc';
$orderBy = "uploaded_at DESC";
if ($sort === 'date_asc') $orderBy = "uploaded_at ASC";
if ($sort === 'category_asc') $orderBy = "category ASC, uploaded_at DESC";
if ($sort === 'category_desc') $orderBy = "category DESC, uploaded_at DESC";
if ($sort === 'id_asc') $orderBy = "id ASC, uploaded_at DESC";
if ($sort === 'id_desc') $orderBy = "id DESC, uploaded_at DESC";
// Fetch all images
$images = [];
$res = $mysqli->query("SELECT * FROM gallery ORDER BY $orderBy");
while ($row = $res->fetch_assoc()) {
    $images[] = $row;
}
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gallery Admin | Rommel Garcia Digital Video & Photography</title>
    <link rel="stylesheet" href="css/post.css">
    <link rel="icon" href="../img/Header-Pic/rommel-logo-v3.svg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />


     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        .bg-light {
  background-color: #161a2d !important;
}
    .popup { animation: transitionIn-Y-bottom 0.5s; } .sub-table { animation: transitionIn-Y-bottom 0.5s; }</style>
</head> 
<body>


    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container-fluid">

            <a class="navbar-brand" href="index.php?page=dashboard">
                <img src="img/rommel-logo.png" alt="Logo" class="d-inline-block align-text-top " />

            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Appointment.php?page=Appointment">Appointment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="post.php?page=Post-image">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="calendar.php?page=Calendar">Calendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="history.php?page=History">History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex log-col" style="gap:10px; color: #b23b3b !important;" href="logout.php"><span class="material-symbols-outlined"> logout </span>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="img/rommel-logo.png" alt="logo" />
        </div>
        <ul class="sidebar-links bt-top">
        <h4><span>Main Menu</span><div class="menu-separator"></div></h4>
        <li><a href="index.php?page=dashboard"><span class="material-symbols-outlined "> dashboard </span>Dashboard</a></li>
        <li><a href="Appointment.php?page=Appointment"><span class="material-symbols-outlined ">Bookmark</span>Appointment</a></li>
        <li><a href="post.php?page=Post-image" class="active"><span class="material-symbols-outlined active">Add_Photo_Alternate</span>Gallery</a></li>
        <li><a href="calendar.php?page=Calendar"><span class="material-symbols-outlined"> Calendar_Month</span>Calendar</a></li>
        <li><a href="history.php?page=History"><span class="material-symbols-outlined"> History </span>History</a></li>
        
        </ul>
        <div class="bottom-log">
            <ul class="sidebar-links log-btn">
            <li><a href="logout.php"><span class="material-symbols-outlined"> logout </span>Logout</a></li>
            </ul>
        </div>
    </aside>
    <section class="content-section">
        <section class="search-and-user">
      


        <div class="d-flex for-text">
                                <span class="nav-title " style="display: grid; place-items: center;"> <span class="material-symbols-outlined">
                                        Library_Add
                                    </span> </span>
                                <h2> Gallery</h2>
                            </div>


            <div class="admin-profile">
                <div class="row-date">
                    <div class="column-date">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">Today's Date</p>
                    <p class="heading-sub12" id="currentDate"></p>
                    </div>

                    <div class="column-button">
                    <!-- <button class="btn-label" id="add-image-btn" style="display: flex;justify-content: center;align-items: center;"><img src="img/icon/add.svg" width="100%"> Add Image</button> -->
                       <a href="calendar.php"> <button class="btn-label"
                                    style="display: flex;justify-content: center;align-items: center;"><img
                                        src="img/calendar.svg" width="100%"></button></a>
                    </div>

                </div>
            </div>


            
        </section>

         <div class="d-flex justify-content-between  dash-body">
                            <p class="heading-main12">Post Image</p>

                            <a  class="non-style-link d-grid">
                              

                                <button class="cssbuttons-io-button" id="add-image-btn">
                                    <svg
                                        height="24"
                                        width="24"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                                    </svg>
                                    <span>Add Image</span>
                                </button>




                            </a>

                        </div>
        <div class="appointment-list-scroll-container scroll-table ">
            <table id="tablepress-30" class="text-center sub-table main-table scrolldown table-responsive  table-striped" border="0" width="100%" >
            <tr><td colspan="4">
                        <center>
                            <div >
                        <table width="93%" class="sub-table main-table scrolldown" border="0" id="gallery-table">
                                    <thead class="text-center">
                                        <tr>
                                            <th class="table-headin">
                                                #
                                                <a href="?sort=<?php echo $sort === 'id_asc' ? 'id_desc' : 'id_asc'; ?>" style="text-decoration:none;">
                                                    <?php if (strpos($sort, 'id') === 0): ?>
                                                        <?php if ($sort === 'id_asc'): ?>
                                                            <span style="font-size:1.1em;">&#9650;</span>
                                                        <?php else: ?>
                                                            <span style="font-size:1.1em;">&#9660;</span>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <span style="color:#bbb;font-size:1.1em;">&#9660;</span>
                                                    <?php endif; ?>
                                                </a>
                                            </th>
                                    <th class="table-headin">Image</th>
                                            <th class="table-headin">
                                                Category
                                                <a href="?sort=<?php echo $sort === 'category_asc' ? 'category_desc' : 'category_asc'; ?>" style="text-decoration:none;">
                                                    <?php if (strpos($sort, 'category') === 0): ?>
                                                        <?php if ($sort === 'category_asc'): ?>
                                                            <span style="font-size:1.1em;">&#9650;</span>
                                                        <?php else: ?>
                                                            <span style="font-size:1.1em;">&#9660;</span>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <span style="color:#bbb;font-size:1.1em;">&#9660;</span>
                                                    <?php endif; ?>
                                                </a>
                                            </th>
                                    <th class="table-headin">
                                        Uploaded
                                        <a href="?sort=<?php echo $sort === 'date_asc' ? 'date_desc' : 'date_asc'; ?>" style="text-decoration:none;">
                                            <?php if (strpos($sort, 'date') === 0): ?>
                                                <?php if ($sort === 'date_asc'): ?>
                                                    <span style="font-size:1.1em;">&#9650;</span>
                                                <?php else: ?>
                                                    <span style="font-size:1.1em;">&#9660;</span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span style="color:#bbb;font-size:1.1em;">&#9660;</span>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="table-headin">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php foreach ($images as $i => $img): ?>
                                <tr>
                                    <td style="font-weight:600;">#<?php echo $img['id']; ?></td>
                                            <td width="30%">
                                                <div class="responsive">
                                                    <div class="gallery">
                                                <a target="_blank" href="../uploads/gallery/<?php echo htmlspecialchars($img['filename']); ?>">
                                                    <img src="../uploads/gallery/<?php echo htmlspecialchars($img['filename']); ?>" class="image-post" alt="gallery image">
                                                    <div class="middle"><div class="text">View</div></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                    <td>
        <form method="POST" style="margin:0;display:inline;" onChange="this.submit()">
            <input type="hidden" name="edit_category" value="1">
            <input type="hidden" name="id" value="<?php echo $img['id']; ?>">
            <select name="category" class="gallery-modal-select" style="min-width:110px;">
                <option value="SOLO" <?php if($img['category']==='SOLO')echo'selected';?>>SOLO</option>
                <option value="DUO" <?php if($img['category']==='DUO')echo'selected';?>>DUO</option>
                <option value="TRIO" <?php if($img['category']==='TRIO')echo'selected';?>>TRIO</option>
                <option value="QUAD" <?php if($img['category']==='QUAD')echo'selected';?>>QUAD</option>
                <option value="DELUXE" <?php if($img['category']==='DELUXE')echo'selected';?>>DELUXE</option>
                <option value="GROUP" <?php if($img['category']==='GROUP')echo'selected';?>>GROUP</option>
                <option value="GRADUATE" <?php if($img['category']==='GRADUATE')echo'selected';?>>GRADUATE</option>
                <option value="UNO" <?php if($img['category']==='UNO')echo'selected';?>>UNO</option>
                <option value="DOS" <?php if($img['category']==='DOS')echo'selected';?>>DOS</option>
                <option value="TRES" <?php if($img['category']==='TRES')echo'selected';?>>TRES</option>
                <option value="CUATRO" <?php if($img['category']==='CUATRO')echo'selected';?>>CUATRO</option>
                <option value="CINCO" <?php if($img['category']==='CINCO')echo'selected';?>>CINCO</option>
                <option value="SEIS" <?php if($img['category']==='SEIS')echo'selected';?>>SEIS</option>
            </select>
        </form>
                                            </td>
                                    <td style="text-align:center;">
                                        <?php echo date('n/j/y H:i', strtotime($img['uploaded_at'])); ?>
                                            </td>
                                    <td>
                                        <div class="events-td" style="display:flex;justify-content:center;gap:8px;">
                                            <button class="btn-primary-soft btn button-icon btn-delete" style="background-image:url('img/icon/delete-iceblue.svg')" onclick="openDeleteModal(<?php echo $img['id']; ?>);return false;">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                <?php endforeach; ?>
                                    </tbody>
                                </table>
                        <?php if (empty($images)): ?>
                            <p class="heading-main12 no-results">No images in the gallery yet.</p>
                        <?php endif; ?>
                            </div>
                        </center>
            </td></tr>
            </table>
        </div>
    <!-- Add New Image Modal (the only upload modal) -->
<div id="addImageModal" class="modal">
  <div class="modal-content gallery-modal-card">
    <span class="close" onclick="closeAddImageModal()">&times;</span>
    <div class="gallery-modal-header">
      <span class="gallery-modal-icon"><i class="fa fa-image"></i></span>
      <h2>Add New Image</h2>
    </div>
    <form id="addImageForm" method="POST" enctype="multipart/form-data" class="gallery-modal-form">
      <input type="hidden" name="upload_image" value="1">
      <label for="galleryImage" class="gallery-drop-area" id="galleryDropArea">
        <input type="file" id="galleryImage" name="image" accept="image/*" style="display:none;" required onchange="previewGalleryImage(event)">
        <div class="gallery-drop-content">
          <i class="fa fa-cloud-upload-alt gallery-drop-icon"></i>
          <span id="galleryDropText">Drag and drop a file or click to select an image</span>
          <img id="galleryImagePreview" src="#" alt="Preview" style="display:none; max-width:100%; margin-top:10px; border-radius:8px;" />
  </div>
      </label>
      <div class="gallery-modal-field">
        <label for="galleryCategory">Category:</label>
        <select name="category" id="galleryCategory" class="gallery-modal-select" required>
          <option value="" selected disabled>Select Category</option>
          <option value="SOLO">SOLO</option>
          <option value="DUO">DUO</option>
          <option value="TRIO">TRIO</option>
          <option value="QUAD">QUAD</option>
          <option value="DELUXE">DELUXE</option>
          <option value="GROUP">GROUP</option>
          <option value="GRADUATE">GRADUATE</option>
          <option value="UNO">UNO</option>
          <option value="DOS">DOS</option>
          <option value="TRES">TRES</option>
          <option value="CUATRO">CUATRO</option>
          <option value="CINCO">CINCO</option>
          <option value="SEIS">SEIS</option>
        </select>
    </div>
      <button type="submit" class="gallery-modal-upload-btn"><i class="fa fa-upload"></i> Upload</button>
                            </form>
  </div>
</div>
<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
  <div class="modal-content gallery-modal-card" style="max-width:340px;">
    <span class="close" onclick="closeDeleteModal()">&times;</span>
    <div class="gallery-modal-header">
      <span class="gallery-modal-icon"><i class="fa fa-trash"></i></span>
      <h2>Delete Image</h2>
    </div>
    <p style="margin-bottom:18px;">Are you sure you want to delete this image?</p>
    <form id="deleteForm" method="GET" style="margin:0;">
      <input type="hidden" name="action" value="delete">
      <input type="hidden" name="id" id="deleteImageId">
      <button type="submit" class="gallery-modal-upload-btn" style="background:#e53935;"><i class="fa fa-trash"></i> Delete</button>
      <button type="button" class="gallery-modal-upload-btn" style="background:#bdbdbd;color:#222;margin-top:8px;" onclick="closeDeleteModal()">Cancel</button>
    </form>
  </div>
</div>
<script>
// Drag and drop effect
const dropArea = document.getElementById('galleryDropArea');
dropArea.addEventListener('dragover', function(e) {
  e.preventDefault();
  dropArea.classList.add('dragover');
});
dropArea.addEventListener('dragleave', function(e) {
  dropArea.classList.remove('dragover');
});
dropArea.addEventListener('drop', function(e) {
  e.preventDefault();
  dropArea.classList.remove('dragover');
  const files = e.dataTransfer.files;
  if (files.length > 0) {
    document.getElementById('galleryImage').files = files;
    previewGalleryImage({ target: { files } });
  }
});
function previewGalleryImage(event) {
  const [file] = event.target.files;
  const preview = document.getElementById('galleryImagePreview');
  if (file) {
    preview.src = URL.createObjectURL(file);
    preview.style.display = 'block';
    document.getElementById('galleryDropText').style.display = 'none';
  } else {
    preview.src = '#';
    preview.style.display = 'none';
    document.getElementById('galleryDropText').style.display = 'block';
  }
}
// Open new modal on button click
const addImageBtn = document.getElementById('add-image-btn');
// Modal show/hide logic
const addImageModal = document.getElementById('addImageModal');
addImageModal.classList.remove('show'); // Ensure hidden by default
addImageBtn.onclick = function() {
  addImageModal.classList.add('show');
};
function closeAddImageModal() {
  addImageModal.classList.remove('show');
}
// Close modal when clicking outside the modal card
addImageModal.addEventListener('click', function(e) {
  if (e.target === addImageModal) {
    closeAddImageModal();
  }
});
document.addEventListener('DOMContentLoaded', function() {
  var closeBtn = document.querySelector('#addImageModal .close');
  if (closeBtn) {
    closeBtn.onclick = closeAddImageModal;
  }
});
// Delete modal logic
function openDeleteModal(id) {
  document.getElementById('deleteImageId').value = id;
  document.getElementById('deleteModal').classList.add('show');
}
function closeDeleteModal() {
  document.getElementById('deleteModal').classList.remove('show');
}
document.addEventListener('DOMContentLoaded', function() {
  var closeBtn = document.querySelector('#deleteModal .close');
  if (closeBtn) closeBtn.onclick = closeDeleteModal;
  var deleteModal = document.getElementById('deleteModal');
  deleteModal.addEventListener('click', function(e) {
    if (e.target === deleteModal) closeDeleteModal();
  });
});
</script>
    </section>
    <script src="js/post.js"></script>
    <script src="js/date.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showEditCategory(id, category) {
    document.getElementById('editCategoryId').value = id;
    document.getElementById('editCategorySelect').value = category;
    document.getElementById('editCategoryModal').style.display = 'block';
}
function closeEditCategoryModal() {
    document.getElementById('editCategoryModal').style.display = 'none';
}
</script>
</body>
</html>