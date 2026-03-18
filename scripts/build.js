let fs = require('fs')
let crypto = require('crypto')
let path = require('path')
let esbuild = require('esbuild')

let distDir = path.resolve(__dirname, '../resources/dist')

let files = {
    'node_modules/local-time/app/assets/javascripts/local-time.es2017-esm.js': 'local-time.js',
}

if (fs.existsSync(distDir)) {
    fs.rmSync(distDir, { recursive: true })
}

fs.mkdirSync(distDir, { recursive: true })

async function build() {
    let manifest = {}

    for (let [src, dest] of Object.entries(files)) {
        let outfile = path.join(distDir, dest)

        await esbuild.build({
            entryPoints: [src],
            outfile,
            bundle: true,
            minify: true,
        })

        let contents = fs.readFileSync(outfile)
        let hash = crypto.createHash('md5').update(contents).digest('hex').slice(0, 8)
        let ext = path.extname(dest)
        let name = dest.replace(ext, '')
        let hashedName = `${name}-${hash}${ext}`

        fs.renameSync(outfile, path.join(distDir, hashedName))
        manifest[`/${dest}`] = `/vendor/local-time-laravel/${hashedName}`
    }

    fs.writeFileSync(path.join(distDir, 'manifest.json'), JSON.stringify(manifest, null, 2) + '\n')

    console.log('Build complete. Manifest:')
    console.log(manifest)
}

build().catch(() => process.exit(1))
