<?php

class Home extends CI_Controller
{
    public function mail()
    {
        $this->load->library('email');
        $this->email->from('nahidparvezmafi@gmail.com', 'Nahid Parvez');
        $this->email->to('labpc1017@gmail.com');
        $this->email->subject('Mail test');
        $this->email->message('This is a test mail');

        if ($this->email->send()) {
            echo "Mail sent";
        } else {
            echo "Mail not sent";
        }
    }
}
