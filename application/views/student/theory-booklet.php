<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-book-open-page-variant"></i>
                </span> 
BookLet/Practise Assignments
            </h3>
        </div>
        <div class="container">
        
        <div class="row row-cards">
    <div class="container">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class='card-body'>

                    <?php
                        if(count($validEnrollmentList) > 0)
                        {
                            for($i=0;$i<count($validEnrollmentList);$i++) //course name
                            {
                                echo "<div class = 'card'>";
                                    echo "<div class='card-header'>";
                                        echo "<strong><a href='javascript:void(0)'>".$validEnrollmentList[$i]['course_name']."</a></strong>";
                                    echo "</div>";
                                    
                                    echo "<div class='card-body'>";
                                        if(count($validEnrollmentList[$i]['course_chapter']) > 0)
                                        {                                            
                                            for($j=0;$j<count($validEnrollmentList[$i]['course_chapter']);$j++) // chapter name
                                            {
                                                echo "<table class='table table-hover table-bordered'>"; //chapter table : Start
                                                    echo "<tr>";
                                                        echo "<td colspan = '3' class='text-center chapter_name'><strong>Chapter : ".$validEnrollmentList[$i]['course_chapter'][$j]->chapter_name."<strong></td>";
                                                    echo "</tr>";

                                                    //Chapter Documents : Start
                                                    if(count($validEnrollmentList[$i]['course_chapter'][$j]->chapter_doc) > 0)
                                                    {
                                                        echo "<tr>";
                                                            echo "<td colspan = '3' >";
                                                                echo "<table class='table table-hover table-bordered'>"; //chpater document table : Start        
                                                                    echo "<tr>";
                                                                        echo "<td><strong>Sr. No.</strong></td>";
                                                                        echo "<td><strong>Document Title</strong></td>";
                                                                        echo "<td><strong>Link</strong></td>";
                                                                    echo "</tr>";
                                                                    $doc_cnt = 1;
                                                                    for($k=0; $k < count($validEnrollmentList[$i]['course_chapter'][$j]->chapter_doc); $k++)
                                                                    {
                                                                        echo "<tr>";            
                                                                            echo "<td>".$doc_cnt."</td>";    
                                                                            echo "<td>".$validEnrollmentList[$i]['course_chapter'][$j]->chapter_doc[$k]->document_title."</td>";    

                                                                            $doc_url = '';
                                                                            $doc_url = base_url("uploads/chapter/".$validEnrollmentList[$i]['course_chapter'][$j]->chapter_master_id."/chapter-documents/".$validEnrollmentList[$i]['course_chapter'][$j]->chapter_doc[$k]->chapter_document_master_id."/".$validEnrollmentList[$i]['course_chapter'][$j]->chapter_doc[$k]->document_file);

                                                                            echo "<td><a href='".$doc_url."' target='_blank'> View <a/></td>";    
                                                                        echo "</tr>";           

                                                                        $doc_cnt++; 
                                                                    }
                                                                echo "</table>";   //chpater document table : End        
                                                            echo "</td>";    
                                                        echo "</tr>";
                                                    }
                                                    else
                                                    {
                                                        echo "<tr>";
                                                            echo "<td colspan = '3' class='text-center'>Chapter documents are not uploaded for this course.</td>";    
                                                        echo "</tr>";
                                                    }
                                                    //Chapter Documents : End


                                                    //Sub Chapter : Start
                                                    if(count($validEnrollmentList[$i]['course_chapter'][$j]->sub_chapters) > 0)
                                                    {
                                                        for($l=0;$l<count($validEnrollmentList[$i]['course_chapter'][$j]->sub_chapters);$l++)
                                                        {
                                                            echo "<tr>";
                                                                echo "<td colspan = '3' >";
                                                                    echo "<table class='table table-hover table-bordered'>"; //Sub chapter table : Start
                                                                        echo "<tr>";
                                                                            echo "<td colspan = '3' class='text-center sub_chapter_name'><strong>Sub Chapter : ".$validEnrollmentList[$i]['course_chapter'][$j]->sub_chapters[$l]->sub_chapter_name."<strong></td>";
                                                                        echo "</tr>";

                                                                        if(count($validEnrollmentList[$i]['course_chapter'][$j]->sub_chapters[$l]->sub_chapter_doc)>0)
                                                                        {
                                                                            echo "<tr>";   
                                                                                echo "<td colspan = '3' >";
                                                                                    echo "<table class='table table-hover table-bordered'>"; //sub chpater document table : Start        
                                                                                        echo "<tr>";
                                                                                            echo "<td><strong>Sr. No.</strong></td>";
                                                                                            echo "<td><strong>Document Title</strong></td>";
                                                                                            echo "<td><strong>Link</strong></td>";
                                                                                        echo "</tr>";

                                                                                        $sub_doc_cnt = 1;
                                                                                        for($p=0;$p<count($validEnrollmentList[$i]['course_chapter'][$j]->sub_chapters[$l]->sub_chapter_doc);$p++)
                                                                                        {
                                                                                            echo "<tr>";    
                                                                                                echo "<td>".$sub_doc_cnt."</td>";    
                                                                                                echo "<td>".$validEnrollmentList[$i]['course_chapter'][$j]->sub_chapters[$l]->sub_chapter_doc[$p]->document_title."</td>";    

                                                                                                $sub_doc_url = '';
                                                                                                $sub_doc_url = base_url("uploads/sub-chapter/".$validEnrollmentList[$i]['course_chapter'][$j]->sub_chapters[$l]->sub_chapter_master_id."/sub-chapter-documents/".$validEnrollmentList[$i]['course_chapter'][$j]->sub_chapters[$l]->sub_chapter_doc[$p]->sub_chapter_document_master_id."/".$validEnrollmentList[$i]['course_chapter'][$j]->sub_chapters[$l]->sub_chapter_doc[$p]->document_file);

                                                                                                echo "<td><a href='".$sub_doc_url."' target='_blank'> View <a/></td>";    
                                                                                            echo "</tr>";   

                                                                                            $sub_doc_cnt++; 
                                                                                        }

                                                                                    echo "</table>";//Subchapter doc table:END                                                                        

                                                                                echo "</td>";        
                                                                            echo "</tr>";   
                                                                        }
                                                                        echo "<tr>";
                                                                            echo "<td colspan = '3' class='text-center'>Sub chapter documents are not uploaded for this sub chapter.</td>";    
                                                                        echo "</tr>";
                                                                    echo "</table>";//Subchapter :END 
                                                                echo "</td>";
                                                            echo "</tr>";                                                                           
                                                        }
                                                        
                                                    }
                                                    else
                                                    {
                                                        echo "<tr>";
                                                            echo "<td colspan = '3' class='text-center'>Sub chapters are not uploaded for this course.</td>";    
                                                        echo "</tr>";
                                                    }
                                                    //Sub Chapter : End
                                                    
                                                echo "</table>";   //chpater table : End     
                                                echo "<hr/>";   
                                            }    
                                        }

                                        
                                        
                                    echo "</div>";

                                echo "</div>";
                            }
                        }
                        else
                        {
                            ?>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h3 class="text-primary">You have not enrolled for course or your enrollment is expired.</h3>
                                    <h4 class="text-primary">You are not allowed to access this page.</h4>
                                </div>
                            </div>
                            
                            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                        <?php
                        }
                    ?>
                </div>
            </div>    
        </div>
    </div>
</div>    

        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">
            <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © Maurya 2024 </span>
            <span class="float-none float-sm-end mt-1 mt-sm-0 text-end">Designed & Developed By <a style="text-decoration: none;" href="https://www.zynovvatech.com/" target="_blank">Zynovvatech</a></span>
        </div>
    </footer>
    <!-- partial -->
</div>

