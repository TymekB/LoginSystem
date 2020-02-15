import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {LoginComponent} from './login/login.component';
import {RegisterComponent} from './register/register.component';
import {DashboardComponent} from './dashboard/dashboard.component';
import {AuthGuardService} from './services/auth-guard.service';
import {LoggedInAuthGuardService} from './logged-in-auth-guard.service';

const routes: Routes = [
    {path: '', redirectTo: 'login', pathMatch: 'full'},
    {path: 'login', component: LoginComponent, canActivate: [LoggedInAuthGuardService]},
    {path: 'register', component: RegisterComponent, canActivate: [LoggedInAuthGuardService]},
    {path: 'dashboard', component: DashboardComponent, canActivate: [AuthGuardService]}
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})
export class AppRoutingModule {
}
