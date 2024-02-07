<?php

class MY_Loader extends CI_Loader {

    
    public function hometemplate($template_name, $vars = array(), $return = FALSE) {
        $view_path = "front/";
        if ($return):
            $content = $this->view($view_path . 'common/head', $vars, $return);
            $content .= $this->view($view_path . 'common/header', $vars, $return);
            $content = $this->view($view_path . 'common/inner_container_open', $vars, $return);
            $content = $this->view($view_path . 'home/telecaller-screen', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
            $content = $this->view($view_path . 'common/inner_container_close', $vars, $return);
            $content .= $this->view($view_path . 'common/footer', $vars, $return);

            return $content;
        else:
            $this->view($view_path . 'common/head', $vars);
            $this->view($view_path . 'common/header', $vars);
            $this->view($view_path . 'common/sidebar', $vars);
            $this->view($view_path . $template_name, $vars);
            $this->view($view_path . 'common/footer', $vars);
        endif;
    }

    public function admintemplate($template_name, $vars = array(), $return = FALSE) {
        //$template_name = 'admin/' . $template_name;
        $view_path = "admin/";
        if ($return):
            $content = $this->view('admin/common/head', $vars, $return);
            $content = $this->view('admin/common/header', $vars, $return);
            $content = $this->view('admin/common/sidebar', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
           // $content .= $this->view('admin/common/pre_footer', $vars, $return);
            $content .= $this->view('admin/common/footer', $vars, $return);

            return $content;
        else:
            $this->view($view_path . 'common/head', $vars);
            $this->view($view_path . 'common/header', $vars);
            $this->view($view_path . 'common/sidebar', $vars);
            $this->view($view_path . $template_name, $vars);
            $this->view($view_path . 'common/footer', $vars);

        endif;
    }

    public function subadmintemplate($template_name, $vars = array(), $return = FALSE) {
        //$template_name = 'admin/' . $template_name;
        $view_path = "subadmin/";
        if ($return):
            $content = $this->view('subadmin/common/head', $vars, $return);
            $content = $this->view('subadmin/common/header', $vars, $return);
            $content = $this->view('subadmin/common/sidebar', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
        //   $content .= $this->view('admin/common/pre_footer', $vars, $return);
            $content .= $this->view('subadmin/common/footer', $vars, $return);

            return $content;
        else:
            $this->view($view_path . 'common/head', $vars);
            $this->view($view_path . 'common/header', $vars);
            $this->view($view_path . 'common/sidebar', $vars);
            $this->view($view_path . $template_name, $vars);
            $this->view($view_path . 'common/footer', $vars);

        endif;
    }

    public function studenttemplate($template_name, $vars = array(), $return = FALSE) {
        $view_path = "student/";
        if ($return):
            $content = $this->view('student/common/head', $vars, $return);
            $content = $this->view('student/common/header', $vars, $return);
            $content = $this->view('student/common/sidebar', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
        //   $content .= $this->view('student/common/pre_footer', $vars, $return);
            $content .= $this->view('student/common/footer', $vars, $return);

            return $content;
        else:
            $this->view($view_path . 'common/head', $vars);
            $this->view($view_path . 'common/header', $vars);
            $this->view($view_path . 'common/sidebar', $vars);
            $this->view($view_path . $template_name, $vars);
            $this->view($view_path . 'common/footer', $vars);

        endif;
    }

}
?>