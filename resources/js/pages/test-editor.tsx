import axios from 'axios';
import React, { useEffect } from 'react';

const TestEditor: React.FC = () => {

    useEffect(() => {
        axios('/api/test/181').then((response) => {
            console.log(response.data);
        });
    }, []);

    return <div>
        
    </div>;
}

export default TestEditor;