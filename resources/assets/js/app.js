require('./bootstrap');

import React from 'react';
import { render } from 'react-dom';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';

import Example from './components/Example';

const index=()=>(
  <Router>
      <div className="wrap">
        <Switch>
          <Route path="/" component={Example} />
        </Switch>
      </div>
    </Router>
)
render(<Example />, document.getElementById('example'));
