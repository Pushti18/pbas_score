<?php
    include("../db_connect.php");
    // getting all values from the HTML form
    if(isset($_POST['submit']))
    {
        $company_name = $_POST['company_name'];
        $location = $_POST['location'];
        $type_of_company = $_POST['type_of_company'];
        $job_description = $_POST['job_description'];
        $skills_required = $_POST['skills_required'];
        $website = $_POST['website'];
        $linkedln = $_POST['linkedln'];
        $students_reference = $_POST['students_reference'];
        $salary = $_POST['salary'];
        $reviews = $_POST['reviews'];
        $students_reviews = $_POST['students_reviews'];
        $terms_and_conditions = $_POST['terms_and_conditions'];
        $stipend = $_POST['stipend'];
        $company_size = $_POST['company_size'];
        

        // if (isset($_FILES['app_form_file']['name']))
        // {
        //   $app_form_file = $_FILES['app_form_file']['name'];
        //   $file_tmp = $_FILES['app_form_file']['tmp_name'];
 
        //   move_uploaded_file($file_tmp,"./pdf/".$app_form_file);
 
          $insertquery ="INSERT INTO company_info_details (company_name, location, type_of_company, job_description, skills_required, website, linkedln, students_reference, salary, reviews, students_reviews, terms_and_conditions, stipend, company_size, status)
          VALUES ('$company_name', '$location', '$type_of_company', '$job_description', '$skills_required', '$website', '$linkedln', '$students_reference', '$salary', '$reviews', '$students_reviews', '$terms_and_conditions', '$stipend', '$company_size' ,1)";

          // $iquery = mysqli_query($conn, $insertquery);
            if ($conn->query($insertquery) === TRUE) {
            echo "New record created successfully";
            echo "<br>";
            echo "<a href=\"ipr_output.php\">View Data</a>";
            } else {
            echo "Error: " . $insertquery . "<br>" . $conn->error;
            }
          }
// 
    // // using sql to create a data entry query
    // $sql = "INSERT INTO research_paper_details (publications, index_rp, type_rp , title_article, journal_magazine_title, impact_factor, vol_no, doi, q_factor, publication_month, publication_year, publication_date, page_no, author, co_author, no_of_author, department, university, country, role, current_status, link_article, file_article, link_journal, abstract, status) VALUES ('$publications', '$index_rp', '$type_rp', '$title_article', '$j_m_title', '$impact_factor', '$vol_no', '$doi', '$q_factor', '$publication_month', '$publication_year','$publication_date', '$pg_no', '$author', '$co_author', '$no_of_author', '$department', '$university', '$country' ,'$role', '$current_status', '$link_article', '$file_article', '$link_journal', '$abstract', 1)";

    

    // $conn->close();

?>