import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  templateUrl: './administration.template.html',
  styleUrls: ['./administration.styles.scss'],
})
export class AdministrationComponent implements OnInit {

  constructor(private router: Router) {}

  ngOnInit(): void {
    this.router.navigate(['administration', 'companies']);
  }
}
