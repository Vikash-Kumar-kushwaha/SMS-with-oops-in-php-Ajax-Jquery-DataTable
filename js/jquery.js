$('document').ready(function () {
  //load table data from backend
  $('#myTable').DataTable({
    ajax: {
      url: '../db_operation/select.php', // URL to the server-side script that fetches the data
      type: 'GET', // HTTP method to use for the AJAX request
      dataSrc: 'data', // JSON property containing the array of records
      succees: function (dataSrc) {
        var datas = JSON.parse(dataSrc);
        console.log(datas);
      },
    },
    columns: [
      { data: 'studid' },
      { data: 'StudName' },
      { data: 'mail', visible: false },
      { data: 'fatherName' },
      { data: 'dob' },
      { data: 'dept_name' },
      { data: 'uploadfile' },
      { data: 'view' },
      { data: 'operation' },
      { data: 'profilePic', visible: false },
      { data: 'gender', visible: false },
      { data: 'motherName', visible: false },
      { data: 'educationlvl', visible: false },
      { data: 'mob', visible: false },
      { data: 'addr', visible: false },
      { data: 'user', visible: false },
      { data: 'dept_id', visible: false },
    ],
    columnDefs: [
      {
        targets: [2, 6, 7, 8],
        orderable: false,
      },
    ],
    initComplete: function () {
      // Handle click event on the "view" button
      $(document).on('click', "button[name='viewEye']", function () {
        var row = $(this).closest('tr');
        var rowData = $('#myTable').DataTable().row(row).data();

        // Access the hidden data
        var viewData = rowData.profilePic;

        // Process the data as needed
        console.log(viewData);
      });
    },
  });
  // loadTableData();

  //data table code snnipet---------------->

  // $('#myTable').DataTable();

  //sidebar handler snippet

  $('.sidebar-btn').click(function () {
    $('.sidebar-container').toggleClass('sidebar-toggle');
    // $('.sidebar-container').css({ width: '200px', display: 'inline' });
    $('#main').toggleClass('main-container');
  });

  //slidetoggle operation

  $('.student-info').click(function () {
    $('.tableData').slideToggle(500);
  });

  //Handler for sorting arrow button

  // $('.arrow-btn').click(function (e) {
  //   e.preventDefault();
  //   var column = $(this).closest('th').data('column');
  //   var sort = $(this).attr('name');

  //   $.ajax({
  //     url: '../db_operation/select.php',
  //     type: 'GET',
  //     data: { column: column, sort: sort },
  //     success: function (data) {
  //       $('tbody[data-table]').html(data);
  //     },
  //     error: function (xhr, status, error) {
  //       console.log(error);
  //     },
  //   });
  // });

  $(document).on('click', 'a[data-dept]', function (e) {
    e.preventDefault();
    var departmentId = $(this).data('dept');
    loadTableData(departmentId);
  });

  // function loadTableData() {
  //   $('#myTable').DataTable({
  //     ajax: {
  //       url: '../db_operation/select.php',
  //       type: 'GET',
  //       dataSrc: 'data',
  //       success: function (data) {
  //         console.log(data);
  //       },
  //     },
  //     columns: [
  //       { data: 'studid' },
  //       { data: 'StudName' },
  //       { data: 'email' },
  //       // { data: 'dob' },
  //       // { data: 'dept_name' },
  //       // { data: 'uploadfile' },
  //       // {data:studid},
  //       // {data:studid},
  //       // {data:studid},
  //     ],
  //   });
  // }
  // loadTableData();
  $('#searchInput').on('keyup', function () {
    console.log('clicked');
    var searchTerm = $(this).val().toLowerCase();
    $('table')
      .find('tbody tr')
      .each(function (index, row) {
        // var rowData = $(row).text().toLocaleLowerCase();
        // var match = rowData.indexOf(searchTerm) > -1;
        // $(row).toggle(match);

        var nameColumn = $(row).find('td:nth-child(2)');
        var rowData = nameColumn.text().toLowerCase();
        var match = rowData.indexOf(searchTerm) > -1;
        $(row).toggle(match);
      });
  });

  //Model handler snippet for update

  $(document).on('click', "button[name='update-btn']", function (e) {
    e.preventDefault();
    var studentId = $(this).data('student-id');
    // console.log('Button clicked for student ID: ' + studentId);

    // GET data for form
    var row = $(this).closest('tr');
    var rowData = $('#myTable').DataTable().row(row).data();

    // Access the hidden data
    var student_id = rowData.studid;
    var student_name = rowData.StudName;
    var father_name = rowData.fatherName;
    var gender = rowData.gender;
    var mother_name = rowData.motherName;
    var dept_id = rowData.dept_id;
    var dept_name = rowData.dept_name;
    var dob = rowData.dob;
    var education_lvl = rowData.educationlvl;
    var mob = rowData.mob;
    var addr = rowData.addr;
    var user_name = rowData.user;
    var email = rowData.mail;
    // SET data in form
    var ele = $('#myModal');

    var trg = ele.find('form').children().children('.row').children('.col-6');

    trg.children('input[name=Studid]').val(student_id);
    trg.children('input[name=FullName]').val(student_name);
    trg.children('input[name=fathername]').val(father_name);
    trg.children('input[name=mothername]').val(mother_name);
    trg.children('input[name=dateofbirth]').val(dob);
    trg.children('input[name=dept_name]').val(dept_name);
    if (gender === 'male') {
      $('#m').prop('checked', true);
      $('#f').prop('checked', false);
    } else if (gender === 'female') {
      $('#m').prop('checked', false);
      $('#f').prop('checked', true);
    } else {
      $('#m').prop('checked', false);
      $('#f').prop('checked', false);
    }
    trg.children('input[name=Email]').val(email);
    trg.children('select[name=edulevel]').val(education_lvl);
    var dept = trg.children('select[name=dept]').val(dept_id);

    // console.log(dept);
    trg.children('input[name=mobNumber]').val(mob);
    trg.children().children('textarea[name=add]').val(addr);
    var uname = trg.children('input[name=user_name]').val(user_name);
    // console.log(uname);
    $(".top-nav button[name='logout']").addClass('hiilogout');
    $('#myModal').show();
  });

  $('.close').click(function () {
    $('#myModal').hide();
  });

  //update form send to backend

  $(document).on('submit', 'form[data-update="update"]', function (event) {
    // Prevent form submission
    event.preventDefault();

    var formData = new FormData(this);
    var id = $("input[name='Studid']").val();
    console.log(id);
    formData.append('action', 'update');

    // console.log($('form').serialize());

    $.ajax({
      url: '../db_operation/databaseOperation.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        // Handle the response from the backend
        var data = JSON.parse(response);
        console.log(data);
        if (data.status === 'error') {
          alert(data.message);
        } else if (data.status === 'success') {
          alert(data.message);
          alert(data.message);

          var updatedDataId = id;
          var backendData = data.data;
          // Get the DataTable instance
          var table = $('#myTable').DataTable();

          // Find the row based on the unique identifier (ID)
          var row = table.row(function (idx, data, node) {
            return data.studid === updatedDataId;
          });

          // Check if the row exists
          if (row.length) {
            // Update the data for the specific row
            var rowData = row.data();
            // rowData.studid = backendData.studid;
            rowData.StudName = backendData.StudName;
            rowData.mail = backendData.mail;
            rowData.fatherName = backendData.fatherName;
            rowData.dob = backendData.dob;
            rowData.dept_name = backendData.dept_name;
            row.data(rowData);
            row.invalidate();
          }

          // Redraw the DataTable to reflect the updated row
          table.columns().visible(true, false); // Show all columns
          table.columns(':gt(6)').visible(false, false); // Hide columns after Dept column
          table.draw(false);
          $('.close').click();
        }
      },
      error: function (xhr, status, error) {
        console.log(error);
      },
    });
  });

  //Code snnipet for open Student Card by click

  $(document).on('click', "button[name='viewEye']", function (e) {
    e.preventDefault();
    var studentId = $(this).data('student-id');
    console.log('Button clicked for student ID: ' + studentId);
    //---------------------hidden data accessing code----------->
    var row = $(this).closest('tr');
    var rowData = $('#myTable').DataTable().row(row).data();

    // Access the hidden data
    var profilePic = rowData.profilePic;
    var studentName = rowData.StudName;
    var fatherName = rowData.fatherName;
    var genderVal = rowData.gender;
    var motherName = rowData.motherName;
    var deptName = rowData.dept_name;
    var dateOfBirth = rowData.dob;
    //get data for card
    var profile_pic = profilePic;
    var student_name = studentName;
    console.log(student_name);
    var father_name = fatherName;
    var dept_name = deptName;
    var mother_name = motherName;
    var dob = dateOfBirth;

    var gender = genderVal;

    //set data into card

    var ele = $('#myModal2').children().children().children('.info-card');
    ele.children().children('img').attr('src', profile_pic);
    ele
      .children()
      .children()
      .children('#student_name')
      .html('<strong>Name:</strong> ' + student_name);
    ele
      .children()
      .children()
      .children('#father_name')
      .html('<strong> Father Name:</strong> ' + father_name);
    ele
      .children()
      .children()
      .children('#mother_name')
      .html('<strong>Mother Name:</strong> ' + mother_name);
    ele
      .children()
      .children()
      .children('#dob')
      .html('<strong>DOB:</strong> ' + dob);
    ele
      .children()
      .children()
      .children('#dept')
      .html('<strong>Dept:</strong> ' + dept_name);
    ele
      .children()
      .children()
      .children('#gender')
      .html('<strong>Gender:</strong> ' + gender);

    $('#myModal2').show();
  });

  $('.close-2').click(function () {
    $('#myModal2').hide();
  });

  //new student registration page load snnipet

  $(document).on('click', '.addNewStudent', function () {
    // $('.addNewStudent').click(function () {
    console.log('clicked');
    $('#main').load('../body/registration.php');
  });

  //Open Total department page

  $("div[data-allDept='allDept']").click(function () {
    var url = $(this).children().attr('href', 'index.php?page=totalDeptCount');
  });

  //form validation and insert value to backend from frontend snippet

  $(document).on(
    'keydown',
    'input[data-validation="mobNumber"]',
    function (event) {
      var input = $(this);
      var errorSpan = input.next('span');
      var value = input.val().trim();
      var isValid = true;

      // Reset error message
      errorSpan.text('');

      if (value.length >= 10 && event.keyCode !== 8 && event.keyCode !== 9) {
        event.preventDefault(); // Prevent further input
      }

      if (value === '') {
        errorSpan.text('Please enter your mobile number').css('color', 'red');
        isValid = false;
      } else if (isNaN(value) || value.length !== 10) {
        errorSpan
          .text('Please enter a valid 10-digit mobile number')
          .css('color', 'red');
        isValid = false;
      }

      // Set input validity
      input.data('valid', isValid);
    }
  );

  $(document).on('keydown', 'input[data-validation="name"]', function (event) {
    var input = $(this);
    var errorSpan = input.next('span');
    var value = input.val().trim();
    var isValid = true;

    // Reset error message
    errorSpan.text('');

    if (value === '') {
      errorSpan.text('Please enter a name').css('color', 'red');
      isValid = false;
    } else if (/\d/.test(value)) {
      errorSpan
        .text('Name should not contain numeric characters')
        .css('color', 'red');
      isValid = false;
    } else if (!/^[a-zA-Z\s]*$/.test(value)) {
      errorSpan
        .text('Name should not contain special characters')
        .css('color', 'red');
      isValid = false;
    }

    // Set input validity
    input.data('valid', isValid);
  });

  $(document).on(
    'submit',
    'form[data-registration="registration"]',
    function (event) {
      // Prevent form submission
      event.preventDefault();

      // Reset error messages
      $('.error').text('');

      // Validate inputs
      var isValid = true;

      // Validate Date of Birth
      var dob = $('#dob').val();
      if (dob.trim() === '') {
        $('#dobError').text('Please enter your date of birth');
        isValid = false;
      }

      // Validate Gender
      var gender = $("input[name='GenderVal']:checked").val();
      if (!gender) {
        $('#genderError').text('Please select your gender');
        isValid = false;
      }

      // Validate Email
      // var email = $("#mail").val();
      // if (email.trim() === "") {
      //     $("#mailError").text("Please enter your email");
      //     isValid = false;
      // }

      // Validate Level
      var level = $('#lvl').val();
      if (level === 'select school') {
        $('#levelError').text('Please select your level');
        isValid = false;
      }

      // Validate Department
      var department = $("select[name='dept']").val();
      if (department === 'Select Dept.') {
        $('#deptError').text('Please select your department');
        isValid = false;
      }

      // Validate Technical Skills
      var skills = $("input[name='skill[]']:checked").length;
      if (skills === 0) {
        $('#skillsError').text('Please select at least one skill');
        isValid = false;
      }

      // Validate Comments
      var comments = $('#floatingTextarea2').val();
      if (comments.trim() === '') {
        $('#commentsError').text('Please enter your comments');
        isValid = false;
      }

      // Validate File Upload
      var fileUpload = $("input[name='file[]']");
      var fileUploadError = $('#fileUploadError');
      var files = fileUpload[0].files;

      if (files.length === 0) {
        fileUploadError.text('Please upload your documents');
        isValid = false;
      }

      // Validate Profile Picture
      var profilePic = $("input[name='profilepic']");
      var profilePicError = $('#profilePicError');
      var profilePicFile = profilePic[0].files[0];

      if (!profilePicFile) {
        profilePicError.text('Please upload your profile picture');
        isValid = false;
      }

      // If all inputs are valid, submit the form
      if (isValid) {
        var formData = new FormData(this);
        formData.append('action', 'insert');
        // Submit the form to the backend

        $.ajax({
          url: '../db_operation/databaseOperation.php',
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            console.log(response);
            try {
              var result = JSON.parse(response);
              console.log(result);

              // Handle the response from the backend
              if (result.status === 'success') {
                alert(result.message);

                $('#main').load('../body/content.php .body-content');
                // loadTableData();
              } else if (result.status === 'error') {
                var errorMessage = '';
                if (Array.isArray(result.message)) {
                  result.message.forEach(function (error) {
                    errorMessage += error;
                  });
                } else {
                  alert(result.message);
                }
                alert(errorMessage);
                window.location.href = '#';
              }
            } catch (error) {
              console.error(error);
              alert(error);
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            alert('An error occurred during the request.');
          },
        });
      } else {
        $('span[id]').css('color', 'red');
      }
    }
  );

  $(document).on('click', "button[name='deleteuser']", function (e) {
    e.preventDefault();
    var table = $('#myTable').DataTable();
    var studentId = $(this).data('delete-studid');
    var row = table.row($(this).closest('tr'));
    var confirmDelete = confirm(
      'Are you sure you want to delete this student?'
    );
    console.log(studentId);
    if (confirmDelete) {
      $.ajax({
        url: '../db_operation/databaseOperation.php',
        type: 'post',
        data: { id: studentId, action: 'delete' },
        success: function (response) {
          var res = JSON.parse(response);
          console.log(response);
          $(row.node()).fadeOut('slow', function () {
            // Remove the row from the DataTable and redraw the table
            row.remove().draw(false);
          });

          console.log(res);
        },
      });
    }
  });

  function handleClock() {
    var now = new Date();
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');
    var seconds = now.getSeconds().toString().padStart(2, '0');
    var timeString = hours + ':' + minutes + ':' + seconds;

    $('.clock').text(timeString);
  }

  setInterval(handleClock, 1000);
});
