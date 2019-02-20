/**
 * Translation.json to ZDoom LANGUAGE file converter
 * 
 * Copyright (c) PROPHESSOR 2019
 */

const json = require('./translation.json');

let output = '// Generated with Translation.json to ZDoom LANGUAGE file converter\n//Copyright (c) PROPHESSOR 2019\n';

for (const string of json) {
    const translations = string[2].sort((a, b) => b[2] - a[2]);

    for (const translation of translations) {
        output += `${string[0]} = "${translation[0]}"; // ${translation[1]} ${translation[2]} ${translation[3]}\n`;
    }
}

console.info(output);