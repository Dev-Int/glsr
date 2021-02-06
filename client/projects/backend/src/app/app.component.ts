import { Component, OnInit } from '@angular/core';
import { Title } from '@angular/platform-browser';
import { ActivatedRoute, NavigationEnd, Router } from '@angular/router';
import { filter, map } from 'rxjs/operators';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
})
export class AppComponent implements OnInit {
  public static DEFAULT_TITLE = 'GLSR';

  constructor(
    private title: Title,
    private route: ActivatedRoute,
    private router: Router,
  ) {}

  ngOnInit(): void {
    const appTitle = this.title.getTitle();
    this.router.events.pipe(
      filter(event => event instanceof NavigationEnd),
      map(() => {
        let child = this.route.firstChild;
        while (child.firstChild) {
          child = child.firstChild;
        }
        if (child.snapshot.data.title) {
          return child.snapshot.data.title;
        }
        return appTitle;
      }),
    ).subscribe((ttl: string) => {
      this.title.setTitle(ttl + ' - ' + AppComponent.DEFAULT_TITLE);
    });
  }
}
