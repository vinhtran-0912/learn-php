import React, { Component } from 'react';
import LoginForm from './loginForm.jsx';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';

export default class Example extends Component {
    render() {
        return (
            <div className="container">
                <LoginForm />
            </div>
        );
    }
}
