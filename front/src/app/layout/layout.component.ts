import { MediaMatcher } from '@angular/cdk/layout';
import { ChangeDetectorRef, Component, OnDestroy, ViewEncapsulation, AfterViewInit } from '@angular/core';
import { MenuItems} from "../shared/menu-items/menu-items";
import { LoginService } from "../user/login/login.service";

/** @title Responsive sidenav */
@Component({
    selector: 'app-full-layout',
    templateUrl: 'layout.component.html',
    styleUrls: [],
})
export class LayoutComponent implements OnDestroy, AfterViewInit {
    mobileQuery: MediaQueryList;

    private _mobileQueryListener: () => void;

    constructor(changeDetectorRef: ChangeDetectorRef, media: MediaMatcher, public menuItems: MenuItems, public loginService: LoginService) {
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
