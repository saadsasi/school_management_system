<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    @php
      $AllChatUserCount = App\Models\ChatModel::getAllChatUserCount()
    @endphp
    <!-- Messages Dropdown Menu -->
    <li class="nav-item">
      <a class="nav-link" href="{{ url('chat') }}">
        <i class="far fa-comments"></i>
        <span class="badge badge-danger navbar-badge">{{ !empty($AllChatUserCount) ? $AllChatUserCount : '' }}</span>
      </a>
    </li>
    </li>
    <!-- Dark Mode Switch -->
    <li class="nav-item">
      <a class="nav-link" href="#" id="darkModeToggle">
        <i class="fas fa-moon" id="darkModeIcon"></i>
        <span id="darkModeText"> <!-- {{ __('messages.dark_mode') }}--> </span>
      </a>
    </li>




<!-- Language Switcher -->
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#" style="display: flex; align-items: center;">
        <div style="background: #007BFF; padding: 4px; border-radius: 4px; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-translate" style="color: white; font-size: 16px;"></i>
        </div>
        <span style="margin-right: 5px; margin-left: 5px;">{{ app()->getLocale() == 'ar' ? 'عربي' : 'English' }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <a href="{{ url('locale/ar') }}" class="dropdown-item">
            العربية
        </a>
        <a href="{{ url('locale/en') }}" class="dropdown-item">
            English
        </a>
    </div>
</li>

  </ul>
</nav>
<!-- /.navbar -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="javascript:;" class="brand-link" style="text-align: center;">
      @if(!empty($getHeaderSetting->getLogo()))
       <img src="{{ $getHeaderSetting->getLogo() }}" style="width: auto;height: 60px;border-radius: 5px;">  
      @else
        <span class="brand-text font-weight-light" style="font-weight: bold !important;font-size: 20px;">{{ __('messages.school') }}</span>
      @endif
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img style="height: 40px;width: 40px;" src="{{ Auth::user()->getProfileDirect() }}" class="img-circle elevation-2" alt="{{ Auth::user()->name }}">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @if(Auth::user()->user_type == 1)
          <li class="nav-item">
            <a href="{{ url('admin/dashboard') }}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                {{ __('messages.dashboard') }}
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/admin/list') }}" class="nav-link @if(Request::segment(2) == 'admin') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                {{ __('messages.admin') }}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/teacher/list') }}" class="nav-link @if(Request::segment(2) == 'teacher') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                {{ __('messages.teacher') }}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/student/list') }}" class="nav-link @if(Request::segment(2) == 'student') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                {{ __('messages.student') }}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/parent/list') }}" class="nav-link @if(Request::segment(2) == 'parent') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                 {{ __('messages.parent') }}
              </p>
            </a>
          </li>
        
          <li class="nav-item">
            <a href="{{ url('admin/registrations/list') }}" class="nav-link @if(Request::segment(2) == 'registration') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                 {{ __('messages.registration') }}
              </p>
            </a>
          </li>

         <li class="nav-item  @if(Request::segment(2) == 'class' || Request::segment(2) == 'subject' || Request::segment(2) == 'assign_subject' || Request::segment(2) == 'assign_class_teacher' || Request::segment(2) == 'class_timetable') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link  @if(Request::segment(2) == 'class' || Request::segment(2) == 'subject' || Request::segment(2) == 'assign_subject' || Request::segment(2) == 'assign_class_teacher' || Request::segment(2) == 'class_timetable') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                       {{ __('messages.academics') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/class/list') }}" class="nav-link @if(Request::segment(2) == 'class') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('messages.class') }}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/subject/list') }}" class="nav-link @if(Request::segment(2) == 'subject') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('messages.subject') }}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/assign_subject/list') }}" class="nav-link @if(Request::segment(2) == 'assign_subject') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('messages.assign_subject') }}</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ url('admin/class_timetable/list') }}" class="nav-link @if(Request::segment(2) == 'class_timetable') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('messages.class_timetable') }}</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ url('admin/assign_class_teacher/list') }}" class="nav-link @if(Request::segment(2) == 'assign_class_teacher') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('messages.assign_class_teacher') }}</p>
                </a>
              </li>
            </ul>
          </li>


          

          <li class="nav-item  @if(Request::segment(2) == 'fees_collection') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link  @if(Request::segment(2) == 'fees_collection') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                 {{ __('messages.fees_collection') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/fees_collection/collect_fees') }}" class="nav-link @if(Request::segment(3) == 'collect_fees') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>  {{ __('messages.collect_fees') }} </p>
                </a>
              </li>      

              <li class="nav-item">
                <a href="{{ url('admin/fees_collection/collect_fees_report') }}" class="nav-link @if(Request::segment(3) == 'collect_fees_report') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>  {{ __('messages.collect_fees_report') }}  </p>
                </a>
              </li>        
            </ul>
        </li>


          <li class="nav-item  @if(Request::segment(2) == 'examinations') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link  @if(Request::segment(2) == 'examinations') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                    {{ __('messages.examinations') }} 
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/examinations/exam/list') }}" class="nav-link @if(Request::segment(3) == 'exam') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>     {{ __('messages.exam') }}  </p>
                </a>
              </li>


              <li class="nav-item">
                <a href="{{ url('admin/examinations/exam_schedule') }}" class="nav-link @if(Request::segment(3) == 'exam_schedule') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>  {{ __('messages.exam_schedule') }}  </p>
                </a>
              </li>


              <li class="nav-item">
                <a href="{{ url('admin/examinations/marks_register') }}" class="nav-link @if(Request::segment(3) == 'marks_register') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>   {{ __('messages.marks_register') }} </p>
                </a>
              </li>


              <li class="nav-item">
                <a href="{{ url('admin/examinations/marks_grade') }}" class="nav-link @if(Request::segment(3) == 'marks_grade') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>   {{ __('messages.marks_grade') }}  </p>
                </a>
              </li>

              
             
            </ul>
          </li>


         <li class="nav-item  @if(Request::segment(2) == 'attendance') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link  @if(Request::segment(2) == 'attendance') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                  {{ __('messages.attendance') }} 
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{ url('admin/attendance/student') }}" class="nav-link @if(Request::segment(3) == 'student') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>  {{ __('messages.student_attendance') }}  </p>
                </a>
              </li>

               <li class="nav-item">
                <a href="{{ url('admin/attendance/report') }}" class="nav-link @if(Request::segment(3) == 'report') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>  {{ __('messages.attendance_report') }} </p>
                </a>
              </li>
             
            </ul>
        </li>


          <li class="nav-item  @if(Request::segment(2) == 'communicate') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link  @if(Request::segment(2) == 'communicate') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                  {{ __('messages.communicate') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{ url('admin/communicate/notice_board') }}" class="nav-link @if(Request::segment(3) == 'notice_board') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p> {{ __('messages.notice_board') }} </p>
                </a>
              </li>


              <li class="nav-item">
                <a href="{{ url('admin/communicate/send_email') }}" class="nav-link @if(Request::segment(3) == 'send_email') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>  {{ __('messages.send_email') }}  </p>
                </a>
              </li>
              

            </ul>
        </li>

        <li class="nav-item @if(Request::segment(2) == 'activities') menu-is-opening menu-open @endif">
    <a href="{{ url('admin/activities/requests') }}" class="nav-link @if(Request::segment(2) == 'activities') active @endif">
        <i class="nav-icon fas fa-running"></i>
        <p> الأنشطة </p>
    </a>
</li>
        
        <li class="nav-item  @if(Request::segment(2) == 'leave') menu-is-opening menu-open @endif">
    <a href="{{ url('admin/leave/requests') }}" class="nav-link  @if(Request::segment(2) == 'leave') active @endif">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p> طلبات المغادرة </p>
    </a>  
</li>



        <li class="nav-item">
            <a href="{{ url('admin/account') }}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                {{ __('messages.my_account') }} 
              </p>
            </a>
          </li>
          


          <li class="nav-item">
            <a href="{{ url('admin/setting') }}" class="nav-link @if(Request::segment(2) == 'setting') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                       {{ __('messages.settings') }} 
              </p>
            </a>
          </li>
         

          <li class="nav-item">
            <a href="{{ url('admin/change_password') }}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                 {{ __('messages.change_password') }}  
              </p>
            </a>
          </li>

         
          @elseif(Auth::user()->user_type == 2)
          <li class="nav-item">
            <a href="{{ url('teacher/dashboard') }}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                {{ __('messages.dashboard') }}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('teacher/my_class_subject') }}" class="nav-link @if(Request::segment(2) == 'my_class_subject') active @endif">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                My Class Subject
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{ url('teacher/my_student') }}" class="nav-link @if(Request::segment(2) == 'my_student') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                My Student
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{ url('teacher/my_calendar') }}" class="nav-link @if(Request::segment(2) == 'my_calendar') active @endif">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                My Calendar
              </p>
            </a>
          </li>
        
          
          <li class="nav-item">
            <a href="{{ url('teacher/my_exam_timetable') }}" class="nav-link @if(Request::segment(2) == 'my_exam_timetable') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                My Exam Timetable
              </p>
            </a>
          </li>

          
          <li class="nav-item">
            <a href="{{ url('teacher/marks_register') }}" class="nav-link @if(Request::segment(2) == 'marks_register') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Marks Register
              </p>
            </a>
          </li>



         <li class="nav-item  @if(Request::segment(2) == 'attendance') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link  @if(Request::segment(2) == 'attendance') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Attendance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{ url('teacher/attendance/student') }}" class="nav-link @if(Request::segment(3) == 'student') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Student Attendance</p>
                </a>
              </li>

               <li class="nav-item">
                <a href="{{ url('teacher/attendance/report') }}" class="nav-link @if(Request::segment(3) == 'report') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Attendance Report</p>
                </a>
              </li>
             
            </ul>
        </li>



          <li class="nav-item">
            <a href="{{ url('teacher/my_notice_board') }}" class="nav-link @if(Request::segment(2) == 'my_notice_board') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                My Notice Board
              </p>
            </a>
          </li>





           <li class="nav-item">
            <a href="{{ url('teacher/account') }}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                My Account
              </p>
            </a>
          </li>
          

          <li class="nav-item">
            <a href="{{ url('teacher/change_password') }}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>

          <!--صلاحيات المشرف-->


          @if(Auth::user()->is_supervisor == 1)
          <li class="nav-header">صلاحيات المشرف</li>

          <li class="nav-item">
            <a href="{{ url('admin/dashboard') }}" class="nav-link @if(Request::segment(1) == 'admin' && Request::segment(2) == 'dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>لوحة تحكم المشرف</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/student/list') }}" class="nav-link @if(Request::segment(2) == 'student') active @endif">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>إدارة الطلاب</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/parent/list') }}" class="nav-link @if(Request::segment(2) == 'parent') active @endif">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>إدارة أولياء الأمور</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/teacher/list') }}" class="nav-link @if(Request::segment(2) == 'teacher') active @endif">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>إدارة المعلمين</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/class/list') }}" class="nav-link @if(Request::segment(2) == 'class') active @endif">
              <i class="nav-icon fas fa-school"></i>
              <p>إدارة الفصول</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/subject/list') }}" class="nav-link @if(Request::segment(2) == 'subject') active @endif">
              <i class="nav-icon fas fa-book"></i>
              <p>إدارة المواد</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/registrations') }}" class="nav-link @if(Request::segment(2) == 'registrations') active @endif">
              <i class="nav-icon fas fa-user-check"></i>
              <p>إدارة التسجيلات</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/attendance/student') }}" class="nav-link @if(Request::segment(2) == 'attendance') active @endif">
              <i class="nav-icon fas fa-user-check"></i>
              <p>الحضور والغياب</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/leave/requests') }}" class="nav-link @if(Request::segment(2) == 'leave') active @endif">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>طلبات المغادرة</p>
            </a>
          </li>
          @endif


          @elseif(Auth::user()->user_type == 3)

          <li class="nav-item">
              <a href="{{ url('student/dashboard') }}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>

           <li class="nav-item">
            <a href="{{ url('student/fees_collection') }}" class="nav-link @if(Request::segment(2) == 'fees_collection') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Fees Collection
              </p>
            </a>
          </li>

           


          <li class="nav-item">
            <a href="{{ url('student/my_calendar') }}" class="nav-link @if(Request::segment(2) == 'my_calendar') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                My Calendar
              </p>
            </a>
          </li>



           <li class="nav-item">
            <a href="{{ url('student/my_subject') }}" class="nav-link @if(Request::segment(2) == 'my_subject') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                My Subject
              </p>
            </a>
          </li>


           <li class="nav-item">
            <a href="{{ url('student/my_timetable') }}" class="nav-link @if(Request::segment(2) == 'my_timetable') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                My Timetable
              </p>
            </a>
          </li>



           <li class="nav-item">
            <a href="{{ url('student/my_exam_timetable') }}" class="nav-link @if(Request::segment(2) == 'my_exam_timetable') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                My Exam Timetable
              </p>
            </a>
          </li>


           <li class="nav-item">
            <a href="{{ url('student/my_exam_result') }}" class="nav-link @if(Request::segment(2) == 'my_exam_result') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                My Exam Result
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{ url('student/my_attendance') }}" class="nav-link @if(Request::segment(2) == 'my_attendance') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                My Attendance
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('student/my_notice_board') }}" class="nav-link @if(Request::segment(2) == 'my_notice_board') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                My Notice Board
              </p>
            </a>
          </li>
          <!--قائمة-->
          

         
            
           <li class="nav-item">
            <a href="{{ url('student/account') }}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                My Account
              </p>
            </a>
          </li>
         

            <li class="nav-item">
            <a href="{{ url('student/change_password') }}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>

          @elseif(Auth::user()->user_type == 4)

          <li class="nav-item">
              <a href="{{ url('parent/dashboard') }}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                   {{ __('messages.parent_dashboard') }} 
                </p>
              </a>
            </li>


         <li class="nav-item">
            <a href="{{ url('parent/my_student') }}" class="nav-link @if(Request::segment(2) == 'my_student') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                  {{ __('messages.parent_my_student') }} 
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{ url('parent/my_student_notice_board') }}" class="nav-link @if(Request::segment(2) == 'my_student_notice_board') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                {{ __('messages.parent_my_student_notice_board') }} 

              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{ url('parent/my_notice_board') }}" class="nav-link @if(Request::segment(2) == 'my_notice_board') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
            {{ __('messages.parent_my_notice_board') }} 
              </p>
            </a>
          </li>

  <!-- قائمة المغادرة -->
<li class="nav-item @if(Request::segment(2) == 'leave') menu-open @endif">
    <a href="#" class="nav-link @if(Request::segment(2) == 'leave') active @endif">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>
            طلبات المغادرة للأبناء
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ url('parent/leave/add') }}" class="nav-link @if(Request::segment(2) == 'leave' && Request::segment(3) == 'add') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>تقديم طلب مغادرة</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('parent/leave/history') }}" class="nav-link @if(Request::segment(2) == 'leave' && Request::segment(3) == 'history') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>سجل طلبات المغادرة</p>
            </a>
        </li>
    </ul>
</li>


         <li class="nav-item">
            <a href="{{ url('parent/account') }}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
              {{ __('messages.parent_my_account') }} 
              </p>
            </a>
          </li>

            <li class="nav-item">
            <a href="{{ url('parent/change_password') }}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                 {{ __('messages.parent_change_password') }} 
              </p>
            </a>
          </li>
          
          @endif

         

          <li class="nav-item">
            <a href="{{ url('logout') }}" class="nav-link">
              <i class="nav-icon far fa-user"></i>
              <p>
                  {{ __('messages.logout') }} 
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>    <!-- /.sidebar -->
  </aside>

  <!-- Dark Mode Styles -->
  <style>
    body.dark-mode {
      background-color: #1a1a1a !important;
      color: #ffffff !important;
    }
    
    body.dark-mode .main-sidebar {
      background-color: #2d2d2d !important;
    }
    
    body.dark-mode .main-header {
      background-color: #2d2d2d !important;
      color: #ffffff !important;
    }
    
    body.dark-mode .nav-link {
      color: #ffffff !important;
    }
    
    body.dark-mode .card {
      background-color: #2d2d2d !important;
      color: #ffffff !important;
    }
  </style>

  <!-- Dark Mode Script -->
 <script>
  document.addEventListener('DOMContentLoaded', function() {
      const darkModeToggle = document.getElementById('darkModeToggle');
      const darkModeIcon = document.getElementById('darkModeIcon');
      const darkModeText = document.getElementById('darkModeText');
      
      // Check for saved dark mode preference
      const isDarkMode = localStorage.getItem('darkMode') === 'true';
      if (isDarkMode) {
          document.body.classList.add('dark-mode');
          darkModeIcon.classList.remove('fa-moon');
          darkModeIcon.classList.add('fa-sun');
         // darkModeText.textContent = '{{ __('messages.light_mode') }}';
      }
      
      darkModeToggle.addEventListener('click', function(e) {
          e.preventDefault();
          document.body.classList.toggle('dark-mode');
          
       //   const isDark = document.body.classList.contains('dark-mode');
          localStorage.setItem('darkMode', isDark);
          
          if (isDark) {
              darkModeIcon.classList.remove('fa-moon');
              darkModeIcon.classList.add('fa-sun');
          //    darkModeText.textContent = '{{ __('messages.light_mode') }}';
          } else {
              darkModeIcon.classList.remove('fa-sun');
              darkModeIcon.classList.add('fa-moon');
           //   darkModeText.textContent = '{{ __('messages.dark_mode') }}';
          }
      });
  });
  </script>  
  