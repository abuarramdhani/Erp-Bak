<?php

class C_HoverCard extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model('SystemIntegration/KaizenTks/M_kaizentimtks');
  }

  /**
   * Render detail of kaizen depend on param
   * 
   * @return HTML response
   */
  public function KaizenList()
  {
    $year = $this->input->get('year');
    $month = $this->input->get('month') ? str_pad($this->input->get('month'), 2, "0", STR_PAD_LEFT) : "";
    $day = $this->input->get('day') ? str_pad($this->input->get('day'), 2, "0", STR_PAD_LEFT) : "";
    $section_code = $this->input->get('section_code');
    $category = $this->input->get('category');
    $withAttachment = $this->input->get('withAttachment');

    $title = "";

    if ($day) {
      $title .= "$day ";
    }

    if ($month) {
      $this->load->library('KonversiBulan');
      $monthInIndonesian = (new KonversiBulan)->KonversiAngkaKeBulan($month);

      $title .= "$monthInIndonesian ";
    }

    if ($year) {
      $title .= "$year ";
    }

    if ($category) {
      $title .= " - $category";
    }

    $getDetail = $this->M_kaizentimtks->getKaizenByParameter($year, $month, $day, $section_code, $category);

    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/HoverCard/V_KaizenList', [
      'data' => $getDetail,
      'title' => $title,
      'withAttachment' => $withAttachment
    ]);
  }

  /**
   * Render Html of employee depend on param
   * 
   * @return HTML Response
   */
  public function EmployeeList()
  {
    $year = $this->input->get('year');
    $month = $this->input->get('month') ? str_pad($this->input->get('month'), 2, "0", STR_PAD_LEFT) : "";
    $day = $this->input->get('day') ? str_pad($this->input->get('day'), 2, "0", STR_PAD_LEFT) : "";
    $section_code = $this->input->get('section_code');

    // :TODO form validation

    $employees = $this->M_kaizentimtks->getEmployeeByParameter($year, $month, $day, $section_code);

    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/HoverCard/V_EmployeeList', [
      'employees' => $employees
    ]);
  }
}
