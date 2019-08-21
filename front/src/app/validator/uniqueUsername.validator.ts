import {Injectable} from '@angular/core';
import {AbstractControl} from '@angular/forms';
import {UserRepositoryService} from '../services/user-repository.service';
import {map} from 'rxjs/operators';
import {Observable} from 'rxjs';
import 'rxjs-compat/add/operator/map';

@Injectable({ providedIn: 'root' })

export class UniqueUsernameValidator {

    static createValidator(userRepository: UserRepositoryService) {
        return (control: AbstractControl): Observable<any> => {
            return userRepository.findByUsername(control.value).pipe(
                map((value: {success}) => {
                    return value.success ? {usernameTaken: true} : null;
                }));
        };
    }
}
