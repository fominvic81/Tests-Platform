import React from 'react';
import { createRoot } from 'react-dom/client';
import { questionEditComponentId } from '..';

const Component: React.FC = () => {

    return <></>;
}

const root = createRoot(document.getElementById(questionEditComponentId)!);
root.render(<Component></Component>);