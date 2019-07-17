import { ChangeDetectorRef, Component, OnDestroy, ViewEncapsulation, AfterViewInit } from '@angular/core';
import { MediaMatcher } from '@angular/cdk/layout';
import {MenuItensService} from "./sidebar/menu-itens.service";

@Component({
  selector: 'app-layout',
  templateUrl: './layout.component.html',
  styleUrls: ['./layout.component.scss']
})
export class LayoutComponent implements OnDestroy, AfterViewInit {

    mobileQuery: MediaQueryList;

    private _mobileQueryListener: () => void;

    constructor(changeDetectorRef: ChangeDetectorRef, media: MediaMatcher, public menuItems: MenuItensService) {
        this.mobileQuery = media.matchMedia('(min-width: 768px)');
        this._mobileQueryListener = () => changeDetectorRef.detectChanges();
        this.mobileQuery.addListener(this._mobileQueryListener);
    }

    ngOnDestroy(): void {
        this.mobileQuery.removeListener(this._mobileQueryListener);
    }
    ngAfterViewInit() {

    }
}
