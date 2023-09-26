import { createRoot } from 'react-dom/client';
import React, { Suspense } from 'react';


const testRoot = document.getElementById('test-react-component');
if (testRoot) {
    const TestEditor = React.lazy(() => import('./pages/test-editor'));
    const root = createRoot(testRoot);
    root.render(
        <TestEditor></TestEditor>
    );
}