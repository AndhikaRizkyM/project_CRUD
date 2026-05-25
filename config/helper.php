<?php
// function : 

function getStatus(int $status): string
{
  return $status ? '<span class="badge bg-primary">Active</span>' : '<span class="badge bg-warning">Inactive</span>';
}




// function getLabel($status)
// {
//   switch ($status) {
//     case '1':
//       return '<span class="badge bg-primary">Active</span>';
//       break;

//     default:
//       return '<span class="badge bg-warning">Inactive</span>';
//       break;
//   }
// }