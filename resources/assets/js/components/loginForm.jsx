import React, { Component } from 'react';
import '../../css/app.css';

export default class LoginForm extends Component {
    render() {
        return (
            <div className="log-form">
                <h2>Login to your account</h2>
                <form>
                    <input name="txtEmail" type="text" title="username" placeholder="username" />
                    <input name="txtPassword" type="password" title="username" placeholder="password" />
                    <button type="submit" className="btn">Login</button>
                    <a className="forgot" href="#">Forgot Username?</a>
                </form>
            </div>
        );
    }
}
