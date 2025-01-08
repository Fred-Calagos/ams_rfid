   // let menu = document.querySelector('#menu-btn');
   // let navbar = document.querySelector('.header .navbar');

   // menu.onclick = () =>{
   //    menu.classList.toggle('fa-times');
   //    navbar.classList.toggle('active');
   // };

   // window.onscroll = () =>{
   //    menu.classList.remove('fa-times');
   //    navbar.classList.remove('active');
   // };

   document.addEventListener('DOMContentLoaded', function(){
      const cd1 = document.querySelector('#close-del');
      const cd2 = document.querySelector('#close-upts');
      const cd3 = document.querySelector('#close-ins');
      const cd4 = document.querySelector('#close-del-adv');
      const cd5 = document.querySelector('#close-upt-e');
      const cd6 = document.querySelector('#close-del-e');
      const cd7 = document.querySelector('#close_teach');
      const cd8 = document.querySelector('#close-del-teach');
      const cd9 = document.querySelector('#close_subj');
      const cd10 = document.querySelector('#close-del-subj');
      const cd11 = document.querySelector('#close_assign');
      const cd12 = document.querySelector('#close-del-assign');
      const cd13 = document.querySelector('#close_pass_r');
      const cd14 = document.querySelector('#close_etr');
      const cd15 = document.querySelector('#close_del_track');
      const cd16 = document.querySelector('#close_sy');
      const cd17 = document.querySelector('#close_del_sy');
      const cd18 = document.querySelector('#close_strand');
      const cd19 = document.querySelector('#close_del_strand');
      const cd20 = document.querySelector('#close_sc');
      const cd21 = document.querySelector('#close_del_subcat');
      const cd22 = document.querySelector('#close_del_user');
      const cd23 = document.querySelector('#close_del_stud');
      const cd24 = document.querySelector('#close_gr');
      const cd25 = document.querySelector('#close_section');
      const cd26 = document.querySelector('#close_del_sec');
      const cd27 = document.querySelector('#close_sis');
      const cd28 = document.querySelector('#close_del_sis');
      const cd29 = document.querySelector('#close_add_sched');
      const cd30 = document.querySelector('#close_esched');
      const cd31 = document.querySelector('#close_attc');
      const cd32 = document.querySelector('#close_attg');
      const cd33 = document.querySelector('#close_del_csched');
      const cd34 = document.querySelector('#close_arc_stud');
      const cd35 = document.querySelector('#close_ret_stud');
      const cd36 = document.querySelector('#close_del_grade');
      const cd37 = document.querySelector('#close_adminrole');



         if(cd1){
            // delete popup button Sched
            cd1.addEventListener('click', function(){
               document.querySelector('.edit-form-container').style.display = 'none';
               document.querySelector('.edit-form-container').style.transition = 'all 0.3s ease';
               window.location.href = 'a-class-sched.php';
            });
         }
         if(cd2){
            // edit popup button Sched
            cd2.addEventListener('click', function(){
               document.querySelector('.edit-form-container1').style.display = 'none';
               document.querySelector('.edit-form-container').style.transition = 'all 0.3s ease';
               window.location.href = 'a-class-sched.php';
            });
         }
         if(cd3){
            // Edit popup button Adviser
            cd3.addEventListener('click', function(){
               document.querySelector('#adv_edit').style.display = 'none';
               document.querySelector('#adv_edit').style.transition = 'all 0.3s ease';
               window.location.href = 'm-instructor.php';
            });
         }
         if(cd4){
            // Edit popup button Adviser
            cd4.addEventListener('click', function(){
               document.querySelector('#adv_del_cont').style.display = 'none';
               document.querySelector('#adv_del_cont').style.transition = 'all 0.3s ease';
               window.location.href = 'm-instructor.php';
            });
         }
         if(cd5){
            // Edit popup button EVENT SCHEDULE
            cd5.addEventListener('click', function(){
               document.querySelector('#edit-form-container2').style.display = 'none';
               document.querySelector('.edit-form-container').style.transition = 'all 0.3s ease';
               window.location.href = 'a-class-sched.php';
            });
         }
         if(cd6){
            // DELETE popup button EVENT SCHEDULE
            cd6.addEventListener('click', function(){
               document.querySelector('#edit-form-container3').style.display = 'none';
               document.querySelector('.edit-form-container').style.transition = 'all 0.3s ease';
               window.location.href = 'a-class-sched.php';
            });
         }
         if(cd7){
            // Edit popup button Teacher Information
            cd7.addEventListener('click', function(){
               document.querySelector('#cont_teach').style.display = 'none';
               document.querySelector('#cont_teach').style.transition = 'all 0.3s ease';
               window.location.href = 'm-teacher.php';
            });
         }
         if(cd8){
            // DELETE popup button Teacher Information
            cd8.addEventListener('click', function(){
               document.querySelector('#teach_cont').style.display = 'none';
               document.querySelector('#teach_cont').style.transition = 'all 0.3s ease';
               window.location.href = 'm-teacher.php';
            });
         }
         if(cd9){
            // Edit popup button SUBJECT NAME
            cd9.addEventListener('click', function(){
               document.querySelector('#cont_subn').style.display = 'none';
               document.querySelector('#cont_subn').style.transition = 'all 0.3s ease';
               window.location.href = 'm-subject.php';
            });
         }
         if(cd10){
            // DELETE popup button Teacher Information
            cd10.addEventListener('click', function(){
               document.querySelector('#sub_cont').style.display = 'none';
               document.querySelector('#sub_cont').style.transition = 'all 0.3s ease';
               window.location.href = 'm-subject.php';
            });
         }
         if(cd11){
            // Edit  ASSIGNED TEACHER
            cd11.addEventListener('click', function(){
               document.querySelector('#eassign_sub').style.display = 'none';
               document.querySelector('#eassign_sub').style.transition = 'all 0.3s ease';
               window.location.href = 'm-teachload.php';
            });
         }
         if(cd12){
            // DELETE ASSIGNED TEACHER
            cd12.addEventListener('click', function(){
               document.querySelector('#del_assign_sub').style.display = 'none';
               document.querySelector('#del_assign_sub').style.transition = 'all 0.3s ease';
               window.location.href = 'm-teachload.php';
            });
         }
         if(cd13){
            // PASSWORD RESET
            cd13.addEventListener('click', function(){
               document.querySelector('#cont_usered').style.display = 'none';
               document.querySelector('#cont_usered').style.transition = 'all 0.3s ease';
               window.location.href = 'm-user-acc.php';
            });
         }
         if(cd14){
            // Edit  TRACK
            cd14.addEventListener('click', function(){
               document.querySelector('#track_cont').style.display = 'none';
               document.querySelector('#track_cont').style.transition = 'all 0.3s ease';
               window.location.href = 'm-track.php';
            });
         }
         if(cd15){
            // DELETE TRACK
            cd15.addEventListener('click', function(){
               document.querySelector('#cont_track').style.display = 'none';
               document.querySelector('#cont_track').style.transition = 'all 0.3s ease';
               window.location.href = 'm-track.php';
            });
         }
         if(cd16){
            // EDITING S.Y.
            cd16.addEventListener('click', function(){
               document.querySelector('#sy_cont').style.display = 'none';
               document.querySelector('#sy_cont').style.transition = 'all 0.3s ease';
               window.location.href = 'm-school-year.php';
            });
         }
         if(cd17){
            // DELETING S.Y.
            cd17.addEventListener('click', function(){
               document.querySelector('#cont_sy').style.display = 'none';
               document.querySelector('#cont_sy').style.transition = 'all 0.3s ease';
               window.location.href = 'm-school-year.php';
            });
         }
         if(cd18){
            // EDITING S.Y.
            cd18.addEventListener('click', function(){
               document.querySelector('#strand_cont').style.display = 'none';
               document.querySelector('#strand_cont').style.transition = 'all 0.3s ease';
               window.location.href = 'm-strand.php';
            });
         }
         if(cd19){
            // DELETING S.Y.
            cd19.addEventListener('click', function(){
               document.querySelector('#cont_strand').style.display = 'none';
               document.querySelector('#cont_strand').style.transition = 'all 0.3s ease';
               window.location.href = 'm-strand.php';
            });
         }
         if(cd20){
            // EDITING S.Y.
            cd20.addEventListener('click', function(){
               document.querySelector('#subcat_cont').style.display = 'none';
               document.querySelector('#subcat_cont').style.transition = 'all 0.3s ease';
               window.location.href = 's-sub-cat.php';
            });
         }
         if(cd21){
            // DELETING S.Y.
            cd21.addEventListener('click', function(){
               document.querySelector('#cont_subcat').style.display = 'none';
               document.querySelector('#cont_subcat').style.transition = 'all 0.3s ease';
               window.location.href = 's-sub-cat.php';
            });
         }
         if(cd22){
            // DELETING USER ACCOUNT
            cd22.addEventListener('click', function(){
               document.querySelector('#user_cont').style.display = 'none';
               document.querySelector('#user_cont').style.transition = 'all 0.3s ease';
               window.location.href = 'm-user-acc.php';
            });
         }
         if(cd23){
            // DELETING USER ACCOUNT
            cd23.addEventListener('click', function(){
               document.querySelector('#stud_cont').style.display = 'none';
               document.querySelector('#stud_cont').style.transition = 'all 0.3s ease';
               window.location.href = 'm-student.php';
            });
         }
         if(cd24){
            // EDITING GRADE LEVEL NAME
            cd24.addEventListener('click', function(){
               document.querySelector('#gr_cont').style.display = 'none';
               document.querySelector('#gr_cont').style.transition = 'all 0.3s ease';
               window.location.href = 'm-class.php';
            });
         }
         if(cd25){
            // EDITING GRADE LEVEL NAME
            cd25.addEventListener('click', function(){
               document.querySelector('#sec_cont1').style.display = 'none';
               document.querySelector('#sec_cont1').style.transition = 'all 0.3s ease';
               // Get the current URL
               // Get the value of a_id from the hidden input named "grade"
            let a_id = document.querySelector('input[name="grade"]').value;
            // Get the current URL
            let currentURL = 'm-class-edit.php';
            // Check if the URL already contains the parameter
            let separator = currentURL.includes('?') ? '&' : '?';
            // Append or update the a_id parameter
            let newURL = currentURL + separator + 'a_id=' + a_id;
            // Redirect to the updated URL
            window.location.href = newURL;
            });
         }
         if(cd26){
            // EDITING GRADE LEVEL NAME
            cd26.addEventListener('click', function(){
               document.querySelector('#cont_sec').style.display = 'none';
               document.querySelector('#cont_sec').style.transition = 'all 0.3s ease';
               // Get the current URL
               // Get the value of a_id from the hidden input named "grade"
            let a_id = document.querySelector('input[name="grade"]').value;
            // Get the current URL
            let currentURL = 'm-class-edit.php';
            // Check if the URL already contains the parameter
            let separator = currentURL.includes('?') ? '&' : '?';
            // Append or update the a_id parameter
            let newURL = currentURL + separator + 'a_id=' + a_id;
            // Redirect to the updated URL
            window.location.href = newURL;
            });
         }
         if(cd27){
            // EDITING GRADE LEVEL NAME
            cd27.addEventListener('click', function(){
               document.querySelector('#sis_cont').style.display = 'none';
               document.querySelector('#sis_cont').style.transition = 'all 0.3s ease';
               window.location.href = 'm-school-info.php';
            });
         }
         if(cd28){
            // DELETING USER ACCOUNT
            cd28.addEventListener('click', function(){
               document.querySelector('#cont_sis').style.display = 'none';
               document.querySelector('#cont_sis').style.transition = 'all 0.3s ease';
               window.location.href = 'm-school-info.php';
            });
         }
         if(cd29){
            // ADD SCHEDULE TO TEACHING LOAD
            cd29.addEventListener('click', function(){
               document.querySelector('#sched_cont').style.display = 'none';
               document.querySelector('#sched_cont').style.transition = 'all 0.3s ease';
               window.location.href = 'm-teachload.php';
            });
         }
         if(cd30){
            // ADD SCHEDULE TO TEACHING LOAD
            cd30.addEventListener('click', function(){
               document.querySelector('#esched_cont').style.display = 'none';
               document.querySelector('#esched_cont').style.transition = 'all 0.3s ease';
               window.location.href = 'm-sched-class.php';
            });
         }
         if(cd31){
            // EDIT CLASS ATTENDANCE
            cd31.addEventListener('click', function(){
               document.querySelector('#att_c').style.display = 'none';
               document.querySelector('#att_c').style.transition = 'all 0.3s ease';
               window.location.href = 'a-attendance-class.php';
            });
         }
         if(cd32){
            // EDIT GATE ATTENDANCE
            cd32.addEventListener('click', function(){
               document.querySelector('#att_g').style.display = 'none';
               document.querySelector('#att_g').style.transition = 'all 0.3s ease';
               window.location.href = 'a-attendance.php';
            });
         }
         if(cd33){
            // DELETE SCHEDULE
            cd33.addEventListener('click', function(){
               document.querySelector('#dsched_cont').style.display = 'none';
               document.querySelector('#dsched_cont').style.transition = 'all 0.3s ease';
               window.location.href = 'm-sched-class.php';
            });
         }
         if(cd34){
            // ARCHIVING STUDENT
            cd34.addEventListener('click', function(){
               document.querySelector('#stud_arc').style.display = 'none';
               document.querySelector('#stud_arc').style.transition = 'all 0.3s ease';
               window.location.href = 'm-student.php';
            });
         }
         if(cd35){
            // RETRIEVING STUDENT
            cd35.addEventListener('click', function(){
               document.querySelector('#stud_ret').style.display = 'none';
               document.querySelector('#stud_ret').style.transition = 'all 0.3s ease';
               window.location.href = 'm-archive.php';
            });
         }
         if(cd36){
            // RETRIEVING STUDENT
            cd36.addEventListener('click', function(){
               document.querySelector('#cont_delGrade').style.display = 'none';
               document.querySelector('#cont_delGrade').style.transition = 'all 0.3s ease';
               window.location.href = 'm-class.php';
            });
         }
         if(cd37){
            // EDITING ADMINISTRATIVE ROLE
            cd37.addEventListener('click', function(){
               document.querySelector('#AdministrativeRoleCont').style.display = 'none';
               document.querySelector('#AdministrativeRoleCont').style.transition = 'all 0.3s ease';
               window.location.href = 'm-adminrole.php';
            });
         }
   })
