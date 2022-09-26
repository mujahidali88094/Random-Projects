<html>
  <head>
    <title>Search Doctors</title>
    <link rel="stylesheet" href="./bootstrap.min.css">
  </head>
<body>
  <div class="container-fluid text-center">
  <h2 class="mb-5">Search Doctors</h2>
  <form action="./Controller" class="container" method="POST">
    <div class="vstack gap-3 m-auto" style="max-width: 15rem;">
      <label for="search">Enter Doctor Name (or part of name) To Search</label>
      <input type="text" name="searchText" class="form-control"/>
      <input type="hidden" name="action" value="searchDoctors" />
      <input type="submit" value="Search" class="btn btn-outline-secondary"/>
    </div>
  </form>
</body>
</html>